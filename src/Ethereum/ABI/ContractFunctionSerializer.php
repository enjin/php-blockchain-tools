<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\Support\StringHelpers as Str;
use InvalidArgumentException;
use phpseclib\Math\BigInteger;

class ContractFunctionSerializer
{
    public function encodeInput(ContractFunction $function, array $data): DataBlock
    {
        return $this->encode($function->methodId(), $function->inputs(), $data);
    }

    public function encodeOutput(ContractFunction $function, array $data): DataBlock
    {
        return $this->encode($function->methodId(), $function->outputs(), $data);
    }

    public function encode(string $methodId, array $functionValueTypes, array $data): DataBlock
    {
        $dataBlock = new DataBlock($functionValueTypes);
        $dataBlock->setMethodId($methodId);

        foreach ($functionValueTypes as $i => $item) {
            /** @var ContractFunctionValueType $item */
            $itemName = $item->name() ?: $i;
            $value = $data[$itemName] ?? null;

            $dataType = $item->dataType();
            $rawType = $item->type();

            $baseType = $dataType->baseType();
            $isArray = $dataType->isArray();

            try {
                if ($isArray) {
                    if ($dataType->isDynamicLengthArray()) {
                        $dataBlock->addDynamicLengthArray($item, $value);
                    } else {
                        $dataBlock->addFixedLengthArray($item, $value);
                    }
                } else {
                    if ($baseType === 'string') {
                        $dataBlock->addString($item, $value);
                    } elseif ($baseType === 'bytes') {
                        $dataBlock->addDynamicLengthBytes($item, $value);
                    } else {
                        $dataBlock->add($item, $value);
                    }
                }
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException('attempting to encode: ' . $itemName . ', ' . $e->getMessage(), 0, $e);
            }
        }

        return $dataBlock;
    }

    public function decodeInput(ContractFunction $function, string $data): array
    {
        return $this->decode($function->methodId(), $function->inputs(), $data);
    }

    public function decodeOutput(ContractFunction $function, string $data): array
    {
        return $this->decode($function->methodId(), $function->outputs(), $data);
    }

    public function decode(string $methodId, array $functionValueTypes, string $data)
    {
        $data = $this->removeSignatureFromData($methodId, $data);

        return $this->decodeWithoutMethodId($functionValueTypes, $data);
    }

    public function decodeWithoutMethodId(array $functionValueTypes, string $data)
    {
        $data = HexConverter::unPrefix($data);
        $index = 0;

        $results = [];

        foreach ($functionValueTypes as $i => $item) {
            /** @var ContractFunctionValueType $item */
            $itemName = $item->name() ?: $i;

            $dataType = $item->dataType();
            $rawType = $item->type();
            $baseType = $dataType->baseType();
            $isArray = $dataType->isArray();

            try {
                if ($isArray) {
                    if ($dataType->isDynamicLengthArray()) {
                        $startIndex = $this->uIntFromIndex($data, $index) * 2;

                        $valuesIndex = $startIndex + 64;
                        $arrayLength = $this->uIntFromIndex($data, $startIndex);

                        $hexValues = $this->hexArrayFromIndex($data, $valuesIndex, $arrayLength);
                        $results[$itemName] = $dataType->decodeArrayValues($hexValues);

                        $index += 64;

                        continue;
                    }

                    // fixed length array
                    $valuesIndex = $index;
                    $arrayLength = $dataType->arrayLength();

                    $hexValues = $this->hexArrayFromIndex($data, $valuesIndex, $arrayLength);
                    $results[$itemName] = $dataType->decodeArrayValues($hexValues);

                    $index += $arrayLength * 64;

                    continue;
                }

                $dynamicLengthTypes = ['bytes', 'string'];

                if (in_array($baseType, $dynamicLengthTypes)) {
                    $startIndex = $this->uIntFromIndex($data, $index) * 2;
                    $valuesIndex = $startIndex + 64;
                    $length = $this->uIntFromIndex($data, $startIndex) * 2;

                    $hexValue = $this->hexFromIndex($data, $valuesIndex, $length);
                    $results[$itemName] = $dataType->decodeBaseType($hexValue);

                    $index += 64;

                    continue;
                }

                $hex = $this->hexFromIndex($data, $index, 64);

                $results[$itemName] = $dataType->decodeBaseType($hex);

                $index += 64;
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException('attempting to decode: ' . $itemName . ', ' . $e->getMessage(), 0, $e);
            }
        }

        return $results;
    }

    public function removeSignatureFromData(string $methodId, string $data): string
    {
        return Str::removeFromBeginning($data, $methodId);
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
