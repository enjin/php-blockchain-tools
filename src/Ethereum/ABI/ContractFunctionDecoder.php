<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\Ethereum\ABI\Exceptions\TypeNotSupportedException;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\Support\StringHelpers as Str;
use phpseclib\Math\BigInteger;
use RuntimeException;
use Throwable;

class ContractFunctionDecoder
{
    /**
     * @var Serializer
     */
    protected $serializer;
    
    protected int $index = 0;
    
    protected ?DataBlockDecoder $results = null;

    public function __construct(Serializer $serializer = null)
    {
        $this->serializer = $serializer ?: Serializer::makeDefault();
    }

    public function decodeInput(ContractFunction $function, string $data): DataBlockDecoder
    {
        return $this->decode(
            $function->methodId(),
            $function->inputs(),
            $data
        );
    }

    public function decodeOutput(ContractFunction $function, string $data): DataBlockDecoder
    {
        return $this->decode(
            $function->methodId(),
            $function->outputs(),
            $data
        );
    }

    public function decode(string $methodId, array $valueTypes, string $data)
    {
        $data = $this->removeSignatureFromData($methodId, $data);

        return $this->decodeDataBlock($valueTypes, $data);
    }

    public function decodeWithoutMethodId(array $valueTypes, string $data)
    {
        return $this->decodeDataBlock($valueTypes, $data);
    }

    public function removeSignatureFromData(string $methodId, string $data): string
    {
        return Str::removeFromBeginning($data, $methodId);
    }

    protected function decodeDataBlock(array $valueTypes, string $data): DataBlockDecoder
    {
        $data = HexConverter::unPrefix($data);

        $this->results = $this->serializer->decoder($valueTypes);

        foreach ($valueTypes as $i => $item) {
            $itemName = $item->name() ?: $i;

            try {
                $this->decodeData($item, $data);
            } catch (Throwable $e) {
                $message = 'when attempting to decode: ' . $itemName . ', caught ' . get_class($e) . ': ' . $e->getMessage();

                throw new RuntimeException($message, 0, $e);
            }
        }

        return $this->results;
    }
    
    protected function decodeData($item, string $data)
    {
        $dataType = $item->dataType();
        $baseType = $dataType->baseType();
        $isArray = $dataType->isArray();
        
        if ($isArray) {
            if ($baseType === 'string') {
                throw new TypeNotSupportedException('string arrays (eg string[] or string[99]) are not supported');
            }
            if ($baseType === 'bytes' && $dataType->bitSize() === 'dynamic') {
                throw new TypeNotSupportedException('bytes arrays (eg bytes[] or bytes[99]) are not supported');
            }
            
            if ($dataType->isDynamicLengthArray()) {
                $startIndex = $this->uIntFromIndex($data, $this->index) * 2;
                
                $valuesIndex = $startIndex + 64;
                $arrayLength = $this->uIntFromIndex($data, $startIndex);
                
                $hexValues = $this->hexArrayFromIndex($data, $valuesIndex, $arrayLength);
    
                $this->results->addDynamicLengthArray($item, $hexValues);
    
                $this->index += 64;
            }
            
            // fixed length array
            $valuesIndex = $this->index;
            $arrayLength = $dataType->arrayLength();
            
            if ($baseType === 'tuple' && !empty($dataType->components())) {
                foreach($dataType->components() as $component) {
                    $this->decodeData($component, $data);
                }
            }
            
            $hexValues = $this->hexArrayFromIndex($data, $valuesIndex, $arrayLength);
    
            $this->results->addFixedLengthArray($item, $hexValues);
            
            $this->index += $arrayLength * 64;
        }
        
        $dynamicLengthTypes = ['bytes', 'string'];
        if (in_array($baseType, $dynamicLengthTypes) && $dataType->bitSize() === 'dynamic') {
            $startIndex = $this->uIntFromIndex($data, $this->index) * 2;
            $valuesIndex = $startIndex + 64;
            
            $length = $this->uIntFromIndex($data, $startIndex) * 2;
            
            $hexValue = $this->hexFromIndex($data, $valuesIndex, $length);
            
            if ($baseType === 'bytes') {
                $this->results->addDynamicLengthBytes($item, $hexValue);
            } elseif ($baseType === 'string') {
                $this->results->addString($item, $hexValue);
            }
    
            $this->index += 64;
        }
        
        $hex = $this->hexFromIndex($data, $this->index, 64);
    
        $this->results->add($item, $hex);
    
        $this->index += 64;
    }

    protected function uIntFromIndex(string $data, int $index): int
    {
        $chunk = $this->hexFromIndex($data, $index, 64);

        return (int) (new BigInteger($chunk, 16))->toString();
    }

    protected function hexArrayFromIndex(string $data, int $index, int $arrayLength): array
    {
        $chunk = $this->hexFromIndex($data, $index, $arrayLength * 64);

        return str_split($chunk, 64);
    }

    protected function hexFromIndex(string $data, int $index, int $length): string
    {
        return substr($data, $index, $length);
    }
}
