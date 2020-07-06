<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\HexConverter;

class DataBlock
{
    /**
     * @var int
     */
    protected $dynamicDataPosition;

    protected $data = [];

    protected $fixedLengthData = [];

    protected $dynamicLengthData = [];

    public function __construct(array $functionValueTypes)
    {
        // Set the dynamic data start position.
        $inputCount = count($functionValueTypes);
        $position = $inputCount * 32;

        /** @var ContractFunctionValueType $input */
        foreach ($functionValueTypes as $item) {
            $dataType = $item->dataType();
            if ($dataType->isFixedLengthArray()) {
                $position += ($dataType->arrayLength() - 1) * 32;
            }
        }

        $this->dynamicDataPosition = $position;
    }

    public function add(string $inputName, string $type, string $value)
    {
        $this->data[] = [
            'name' => $inputName,
            'type' => $type,
            'value' => $value,
        ];
    }

    public function addFixedLengthArray(string $inputName, string $type, array $values)
    {
        $this->fixedLengthData[] = [
            'name' => $inputName,
            'type' => $type,
            'values' => $values,
        ];
    }

    public function addDynamicLengthArray(string $inputName, string $type, array $values)
    {
        $length = count($values);

        if (!$values) {
            $length = 0;
        }
        $this->dynamicLengthData[] = [
            'name' => $inputName,
            'is_array' => true,
            'type' => $type,
            'position' => $this->dynamicPositionFor($length),
            'length' => $length,
            'values' => $values,
        ];
    }

    public function addDynamicLengthBytes(string $inputName, string $type, ?string $value)
    {
        if ($value === null) {
            $value = 0;
        }

        $length = strlen($value);

        if (ltrim($value, '0') === '') {
            $length = 0;
        }

        $this->dynamicLengthData[] = [
            'name' => $inputName,
            'type' => $type,
            'is_array' => false,
            'position' => $this->dynamicPositionFor($length),
            'length' => $length,
            'values' => $value,
        ];
    }

    public function addString(string $inputName, string $value)
    {
        $length = strlen($value);

        if (!$value) {
            $length = 0;
        }
        $this->dynamicLengthData[] = [
            'name' => $inputName,
            'type' => 'string',
            'position' => $this->dynamicPositionFor($length),
            'length' => $length,
            'values' => $value,
        ];
    }

    public function toArray(): array
    {
        return array_map(function ($item) {
            return $item['value'];
        }, $this->toArrayWithMeta());
    }

    public function toArrayWithMeta(): array
    {
        $output = [];
        foreach ($this->data as $item) {
            $output[] = $item;
        }

        foreach ($this->fixedLengthData as $item) {
            $name = $item['name'];
            $values = $item['values'];
            $type = $item['type'];

            foreach ($values as $i => $value) {
                $output[] = [
                    'name' => $name . '[' . $i . '] value',
                    'type' => $type,
                    'value' => $value,
                ];
            }
        }

        foreach ($this->dynamicLengthData as $item) {
            $name = $item['name'];
            $position = $item['position'];

            $output[] = [
                'name' => $name . ' values position',
                'value' => $position,
            ];
        }

        foreach ($this->dynamicLengthData as $item) {
            $name = $item['name'];
            $values = $item['values'];
            $length = $item['length'];
            $type = $item['type'];

            if ($type === 'bytes' || $type === 'string') {
                $output[] = [
                    'name' => "{$name} length: {$length}",
                    'type' => $type,
                    'value' => HexConverter::intToHexUInt($length, 64),
                ];

                $output[] = [
                    'name' => $name . ' value',
                    'type' => $type,
                    'value' => $values,
                ];
            } else {
                $output[] = [
                    'name' => "{$name} length: {$length}",
                    'type' => $type,
                    'value' => HexConverter::intToHexUInt($length, 64),
                ];

                foreach ($values as $i => $value) {
                    $output[] = [
                        'name' => $name . '[' . $i . '] value',
                        'type' => $type,
                        'value' => $value,
                    ];
                }
            }
        }

        return $output;
    }

    protected function dynamicPositionFor(int $length): string
    {
        $value = HexConverter::intToHexUInt($this->dynamicDataPosition, 64);
        $this->dynamicDataPosition += ($length * 32) + 32;

        return $value;
    }
}
