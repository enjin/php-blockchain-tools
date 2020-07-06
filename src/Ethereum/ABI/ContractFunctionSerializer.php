<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;

class ContractFunctionSerializer
{
    public function encodeInput(ContractFunction $function, array $data): DataBlock
    {
        return $this->encode($function->inputs(), $data);
    }

    public function encodeOutput(ContractFunction $function, array $data): DataBlock
    {
        return $this->encode($function->outputs(), $data);
    }

    public function encode(array $functionValueTypes, array $data): DataBlock
    {
        $dataBlock = new DataBlock($functionValueTypes);

        foreach ($functionValueTypes as $i => $input) {
            /** @var ContractFunctionValueType $input */
            $inputName = $input->name() ?: $i;
            $value = $data[$inputName] ?? null;

            $dataType = $input->dataType();
            $rawType = $input->type();
            $baseType = $dataType->baseType();
            $isArray = $dataType->isArray();

            if ($isArray) {
                $value = $dataType->encodeArrayValues($value);
                if ($dataType->isDynamicLengthArray()) {
                    $dataBlock->addDynamicLengthArray($inputName, $rawType, $value);
                } else {
                    $dataBlock->addFixedLengthArray($inputName, $rawType, $value);
                }
            } else {
                $value = $dataType->encodeBaseType($value);

                if ($baseType === 'string') {
                    $dataBlock->addString($inputName, $value);
                } elseif ($baseType === 'bytes') {
                    $dataBlock->addDynamicLengthBytes($inputName, $rawType, $value);
                } else {
                    $dataBlock->add($inputName, $rawType, $value);
                }
            }
        }

        return $dataBlock;
    }

    public function decodeInput(ContractFunction $function, array $data): DataBlock
    {
        return $this->decode($function->inputs(), $data);
    }

    public function decodeOutput(ContractFunction $function, array $data): DataBlock
    {
        return $this->decode($function->outputs(), $data);
    }

    public function decode(array $functionValueTypes, array $data): DataBlock
    {
    }
}
