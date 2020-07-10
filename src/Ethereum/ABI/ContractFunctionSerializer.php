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
                    $value = $dataType->encodeArrayValues($value);

                    if ($dataType->isDynamicLengthArray()) {
                        $dataBlock->addDynamicLengthArray($itemName, $rawType, $value);
                    } else {
                        $dataBlock->addFixedLengthArray($itemName, $rawType, $value);
                    }
                } else {
                    $value = $dataType->encodeBaseType($value);

                    if ($baseType === 'string') {
                        $dataBlock->addString($itemName, $value);
                    } elseif ($baseType === 'bytes') {
                        $dataBlock->addDynamicLengthBytes($itemName, $rawType, $value);
                    } else {
                        $dataBlock->add($itemName, $rawType, $value);
                    }
                }
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException('name: ' . $itemName . ', ' . $e->getMessage());
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

            if ($isArray) {
                if ($dataType->isDynamicLengthArray()) {
                    $startIndex = $this->uIntFromIndex($data, $index) * 2;
                    $length = $this->uIntFromIndex($data, $startIndex);
                    $valuesIndex = $startIndex + 64;
                    $hexValues = $this->hexArrayFromIndex($data, $valuesIndex, $length);
                    $results[$itemName] = $dataType->decodeArrayValues($hexValues);

                    $index += 64;

                    continue;
                }

                // fixed length array
                $length = $dataType->arrayLength();
                $hexValues = $this->hexArrayFromIndex($data, $index, $length);
                $results[$itemName] = $dataType->decodeArrayValues($hexValues);

                $index += $length * 64;

                continue;
            }

            $dynamicLengthTypes = ['bytes', 'string'];

            if (in_array($baseType, $dynamicLengthTypes)) {
                $startIndex = $this->uIntFromIndex($data, $index) * 2;
                $length = $this->uIntFromIndex($data, $startIndex);
                $valuesIndex = $startIndex + 64;
                $hexValue = $this->hexFromIndex($data, $valuesIndex, $length);
                $values = $dataType->decodeBaseType($hexValue);

                $results[$itemName] = $values;

                $index += $length * 64;

                continue;
            }

            $hex = $this->hexFromIndex($data, $index);

            $results[$itemName] = $dataType->decodeBaseType($hex);

            $index += 64;
        }

        return $results;
    }

    public function removeSignatureFromData(string $methodId, string $data): string
    {
        return Str::removeFromBeginning($data, $methodId);
    }

    protected function uIntFromIndex(string $data, int $index): int
    {
        $chunk = $this->hexFromIndex($data, $index);

        return (int) (new BigInteger($chunk, 16))->toString();
    }

    protected function hexArrayFromIndex(string $data, int $index, int $length): array
    {
        $chunk = $this->hexFromIndex($data, $index, $length);

        return str_split($chunk, 64);
    }

    protected function hexFromIndex(string $data, int $index, int $length = 1): string
    {
        return substr($data, $index, $length * 64);
    }
}

