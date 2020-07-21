<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEventInput;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;

class DataBlockDecoder
{
    protected $data = [];

    protected $keys = [];

    public function __construct(array $functionValueTypes)
    {
        /** @var ContractFunctionValueType $input */
        foreach ($functionValueTypes as $item) {
            $this->keys[] = $item->name();
        }
    }

    public function addEventTopic(ContractEventInput $valueType, $value)
    {
        $this->data[$valueType->name()] = $value;
    }

    public function add(ContractFunctionValueType $valueType, $value)
    {
        $this->data[$valueType->name()] = $value;
    }

    public function addFixedLengthArray(ContractFunctionValueType $valueType, array $values)
    {
        $this->data[$valueType->name()] = $values;
    }

    public function addDynamicLengthArray(ContractFunctionValueType $valueType, array $values)
    {
        $this->data[$valueType->name()] = $values;
    }

    public function addDynamicLengthBytes(ContractFunctionValueType $valueType, $value)
    {
        $this->data[$valueType->name()] = $value;
    }

    public function addString(ContractFunctionValueType $valueType, string $value)
    {
        $this->data[$valueType->name()] = $value;
    }

    public function toArray(): array
    {
        $output = [];
        foreach ($this->keys as $key) {
            $output[$key] = $this->data[$key];
        }

        return $output;
    }

    public function merge(self $decoder)
    {
        $this->data = array_merge($this->data, $decoder->toArray());
    }
}
