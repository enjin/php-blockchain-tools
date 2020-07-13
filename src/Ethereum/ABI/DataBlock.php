<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;

class DataBlock
{
    /**
     * @var int
     */
    protected $dynamicDataPosition;

    protected $data = [];

    protected $fixedLengthData = [];

    protected $dynamicLengthData = [];

    /**
     * @var string
     */
    protected $methodId;

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

    public function setMethodId(string $methodId)
    {
        $this->methodId = $methodId;
    }

    public function methodId(): string
    {
        return $this->methodId;
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

    public function addDynamicLengthBytes(string $inputName, string $type, ?string $value, int $length)
    {
        $positionLength = ceil($length / 64);

        $values = str_split($value, 64);

        $last = array_pop($values);
        $values[] = HexUInt256::padRight($last);

        $this->dynamicLengthData[] = [
            'name' => $inputName,
            'type' => $type,
            'is_array' => false,
            'position' => $this->dynamicPositionFor($positionLength),
            'length' => $length,
            'values' => $values,
        ];
    }

    public function addString(string $inputName, string $value, string $length)
    {
        $positionLength = ceil($length / 32);

        $values = str_split($value, 64);

        $last = array_pop($values);
        $values[] = HexUInt256::padRight($last);

        $this->dynamicLengthData[] = [
            'name' => $inputName,
            'type' => 'string',
            'position' => $this->dynamicPositionFor($positionLength),
            'length' => $length,
            'values' => $values,
        ];
    }

    public function toString(): string
    {
        return $this->methodId() . implode('', $this->toArray());
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
                'value_decoded' => $position,
                'value_index' => $position * 2,
                'chunk_index' => ($position * 2) / 64,
                'value' => HexConverter::intToHexUInt($position, 64),
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
                    'value_decoded' => $length,
                    'value_hex_string_length' => $position * 2,
                    'chunk_size' => ($length * 2) / 64,
                    'value' => HexConverter::intToHexUInt($length, 64),
                ];

                foreach ($values as $i => $value) {
                    $output[] = [
                        'name' => $name . ' value chunk[' . $i . ']',
                        'type' => $type,
                        'value' => $value,
                    ];
                }
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

        $dataIndex = 0;
        foreach ($output as $index => $row) {
            $output[$index]['index_from'] = $dataIndex;
            $output[$index]['index_to'] = $dataIndex + 64;
            $dataIndex += 64;
        }

        return $output;
    }

    protected function dynamicPositionFor(int $length): string
    {
        $value = $this->dynamicDataPosition;
        $this->dynamicDataPosition += ($length * 32) + 32;

        return $value;
    }
}
