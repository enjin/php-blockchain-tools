<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\Ethereum\ABI\Exceptions\TypeNotSupportedException;
use RuntimeException;
use Throwable;

class ContractFunctionEncoder
{
    /**
     * @var string
     */
    protected $encoderClass;

    public function __construct(string $encoderClass = DataBlockEncoder::class)
    {
        Contract::validateEncoderClass($encoderClass);
        $this->encoderClass = $encoderClass;
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
        $dataBlock = new $this->encoderClass($functionValueTypes);
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
                    if ($baseType === 'string') {
                        throw new TypeNotSupportedException('string arrays (eg string[] or string[99]) are not supported');
                    }
                    if ($baseType === 'bytes' && $dataType->bitSize() === 'dynamic') {
                        throw new TypeNotSupportedException('bytes arrays (eg bytes[] or bytes[99]) are not supported');
                    }

                    if ($dataType->isDynamicLengthArray()) {
                        $dataBlock->addDynamicLengthArray($item, $value);
                    } else {
                        $dataBlock->addFixedLengthArray($item, $value);
                    }
                } else {
                    if ($baseType === 'string') {
                        $dataBlock->addString($item, $value);
                    } elseif ($baseType === 'bytes') {
                        if ($dataType->bitSize() === 'dynamic') {
                            $dataBlock->addDynamicLengthBytes($item, $value);
                        } else {
                            $dataBlock->addFixedLengthBytes($item, $value);
                        }
                    } else {
                        $dataBlock->add($item, $value);
                    }
                }
            } catch (Throwable $e) {
                $message = 'when attempting to encode: ' . $itemName . ', caught ' . get_class($e) . ': ' . $e->getMessage();

                throw new RuntimeException($message, 0, $e);
            }
        }

        return $dataBlock;
    }
}
