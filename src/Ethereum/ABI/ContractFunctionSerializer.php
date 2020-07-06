<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionInput;

class ContractFunctionSerializer
{
    public function encode(ContractFunction $function, array $data): DataBlock
    {
        $dataBlock = new DataBlock($function);

        foreach ($function->inputs() as $i => $input) {
            /** @var ContractFunctionInput $input */
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

    public function decode(ContractFunction $function, string $data): array
    {
    }
}
