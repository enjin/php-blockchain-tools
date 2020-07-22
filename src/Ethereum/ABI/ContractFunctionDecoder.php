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
     * @var string
     */
    protected $decoderClass;

    public function __construct(string $decoderClass = DataBlockDecoder::class)
    {
        Contract::validateDecoderClass($decoderClass);
        $this->decoderClass = $decoderClass;
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

        return $this->decodeData($valueTypes, $data);
    }

    public function decodeWithoutMethodId(array $valueTypes, string $data)
    {
        return $this->decodeData($valueTypes, $data);
    }

    public function removeSignatureFromData(string $methodId, string $data): string
    {
        return Str::removeFromBeginning($data, $methodId);
    }

    protected function decodeData(array $valueTypes, string $data): DataBlockDecoder
    {
        $data = HexConverter::unPrefix($data);
        $index = 0;

        /** @var DataBlockDecoder $results */
        $results = new $this->decoderClass($valueTypes);

        foreach ($valueTypes as $i => $item) {
            /** @var ContractFunctionValueType $item */
            $itemName = $item->name() ?: $i;

            $dataType = $item->dataType();
            $rawType = $item->type();
            $baseType = $dataType->baseType();
            $isArray = $dataType->isArray();

            try {
                if ($isArray) {
                    if ($baseType === 'string') {
                        throw new TypeNotSupportedException('string arrays (eg string[] or string[99]) are not supported ');
                    }
                    if ($baseType === 'bytes' && $dataType->bitSize() === 'dynamic') {
                        throw new TypeNotSupportedException('bytes arrays (eg bytes[] or bytes[99]) are not supported ');
                    }

                    if ($dataType->isDynamicLengthArray()) {
                        $startIndex = $this->uIntFromIndex($data, $index) * 2;

                        $valuesIndex = $startIndex + 64;
                        $arrayLength = $this->uIntFromIndex($data, $startIndex);

                        $hexValues = $this->hexArrayFromIndex($data, $valuesIndex, $arrayLength);

                        $results->addDynamicLengthArray($item, $hexValues);

                        $index += 64;

                        continue;
                    }

                    // fixed length array
                    $valuesIndex = $index;
                    $arrayLength = $dataType->arrayLength();

                    $hexValues = $this->hexArrayFromIndex($data, $valuesIndex, $arrayLength);

                    $results->addFixedLengthArray($item, $hexValues);

                    $index += $arrayLength * 64;

                    continue;
                }

                $dynamicLengthTypes = ['bytes', 'string'];
                if (in_array($baseType, $dynamicLengthTypes) && $dataType->bitSize() === 'dynamic') {
                    $startIndex = $this->uIntFromIndex($data, $index) * 2;
                    $valuesIndex = $startIndex + 64;

                    $length = $this->uIntFromIndex($data, $startIndex) * 2;

                    $hexValue = $this->hexFromIndex($data, $valuesIndex, $length);

                    if ($baseType === 'bytes') {
                        $results->addDynamicLengthBytes($item, $hexValue);
                    } elseif ($baseType === 'string') {
                        $results->addString($item, $hexValue);
                    }

                    $index += 64;

                    continue;
                }

                $hex = $this->hexFromIndex($data, $index, 64);

                $results->add($item, $hex);

                $index += 64;
            } catch (Throwable $e) {
                throw new RuntimeException('attempting to decode: ' . $itemName . ', ' . $e->getMessage(), 0, $e);
            }
        }

        return $results;
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
