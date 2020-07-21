<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use InvalidArgumentException;

class ContractFunctionEncoder
{
    /**
     * @var string
     */
    protected $dataBlockEncoderClass;

    public function __construct(string $dataBlockEncoderClass = DataBlockEncoder::class)
    {
        $this->dataBlockEncoderClass = $dataBlockEncoderClass;
    }

    public function encodeInput(ContractFunction $function, array $data): DataBlockEncoder
    {
        return $this->encode($function->methodId(), $function->inputs(), $data);
    }

    public function encodeOutput(ContractFunction $function, array $data): DataBlockEncoder
    {
        return $this->encode($function->methodId(), $function->outputs(), $data);
    }

    public function encode(string $methodId, array $functionValueTypes, array $data): DataBlockEncoder
    {
        /** @var DataBlockEncoder $dataBlock */
        $dataBlock = new $this->dataBlockEncoderClass($functionValueTypes);
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
}
