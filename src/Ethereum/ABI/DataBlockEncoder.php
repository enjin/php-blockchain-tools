<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;

class DataBlockEncoder
{
    /**
     * @var int
     */
    protected $dynamicDataPosition;

    protected $data = [];

    protected $fixedLengthData = [];

    protected $dynamicLengthData = [];

    protected $keys = [];

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

            $this->keys[] = $item->name();
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

    public function add(ContractFunctionValueType $valueType, $value)
    {
        $this->addRaw(
            $valueType->name(),
            $valueType->type(),
            $value,
            $value
        );
    }

    public function addFixedLengthArray(ContractFunctionValueType $valueType, array $values)
    {
        $this->addFixedLengthArrayRaw(
            $valueType->name(),
            $valueType->type(),
            $values,
            $values
        );
    }

    public function addDynamicLengthArray(ContractFunctionValueType $valueType, array $values)
    {
        $this->addDynamicLengthArrayRaw(
            $valueType->name(),
            $valueType->type(),
            $values,
            $values
        );
    }

    public function addDynamicLengthArrayRaw(
        string $inputName,
        string $type,
        array $values,
        array $valuesEncoded
    ) {
        $length = count($valuesEncoded);

        $this->dynamicLengthData[$inputName] = [
            'name' => $inputName,
            'is_array' => true,
            'type' => $type,
            'position' => $this->dynamicPositionFor($length),
            'length' => $length,
            'values_provided' => $values,
            'values_encoded' => $valuesEncoded,
        ];
    }

    public function addDynamicLengthBytes(ContractFunctionValueType $valueType, $value)
    {
        $bytes = HexConverter::hexToBytes($value);
        $length = count($bytes);

        $valueEncoded = str_split($value, 64);

        $last = array_pop($valueEncoded);
        $valueEncoded[] = HexUInt256::padRight($last);

        $this->addDynamicLengthBytesRaw(
            $valueType->name(),
            $valueType->type(),
            $value,
            $valueEncoded,
            $length
        );
    }

    public function addFixedLengthBytes(ContractFunctionValueType $valueType, $value)
    {
        $valueEncoded = $value;
        $this->addFixedLengthBytesRaw(
            $valueType->name(),
            $valueType->type(),
            $value,
            $valueEncoded
        );
    }

    public function addString(ContractFunctionValueType $valueType, $value)
    {
        $str = HexConverter::hexToString($value);
        $length = strlen($str);

        $valueEncoded = str_split($value, 64);
        $last = array_pop($valueEncoded);
        $valueEncoded[] = HexUInt256::padRight($last);

        $this->addStringRaw(
            $valueType->name(),
            $value,
            $valueEncoded,
            $length
        );
    }

    public function toString(): string
    {
        return '0x' . $this->toStringUnPrefixed();
    }

    public function toStringUnPrefixed(): string
    {
        return $this->methodId() . implode('', $this->toArray());
    }

    public function toArray(): array
    {
        return array_map(function ($item) {
            return $item['value_encoded'];
        }, $this->toArrayWithMeta());
    }

    public function toArrayWithMeta(): array
    {
        $output = [];

        foreach ($this->keys as $key) {
            if ($this->data[$key] ?? false) {
                $output[] = $this->data[$key];

                continue;
            } elseif ($this->fixedLengthData[$key] ?? false) {
                $output = $this->addFixedLengthDataToOutput($output, $this->fixedLengthData[$key]);
            } elseif ($this->dynamicLengthData[$key] ?? false) {
                $output = $this->addDynamicLengthDataToOutput($output, $this->dynamicLengthData[$key]);
            }
        }

        foreach ($this->keys as $key) {
            if ($this->dynamicLengthData[$key] ?? false) {
                $item = $this->dynamicLengthData[$key];
                $name = $item['name'];
                $values = $item['values_provided'];
                $valuesEncoded = $item['values_encoded'];
                $length = $item['length'];
                $type = $item['type'];

                if ($type === 'bytes' || $type === 'string') {
                    $output[] = [
                        'name' => "{$name} length: {$length}",
                        'type' => $type,
                        'value' => $length,
                        'value_encoded' => HexConverter::uintToHex($length, 64),
                        'length_hex_string' => $length * 2,
                        'length_chunk_size' => ($length * 2) / 64,
                    ];

                    foreach ($valuesEncoded as $i => $encoded) {
                        $output[] = [
                            'name' => $name . ' value chunk[' . $i . ']',
                            'type' => $type,
                            'value_encoded' => $encoded,
                        ];
                    }
                } else {
                    $output[] = [
                        'name' => "{$name} length: {$length}",
                        'type' => $type,
                        'value_encoded' => HexConverter::uintToHex($length, 64),
                    ];

                    foreach ($valuesEncoded as $i => $encoded) {
                        $output[] = [
                            'name' => $name . '[' . $i . '] value',
                            'type' => $type,
                            'value_provided' => $values[$i],
                            'value_encoded' => $encoded,
                        ];
                    }
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

    protected function addRaw(string $inputName, string $type, $value, string $valueEncoded)
    {
        $this->data[$inputName] = [
            'name' => $inputName,
            'type' => $type,
            'value_provided' => $value,
            'value_encoded' => $valueEncoded,
        ];
    }

    protected function addFixedLengthArrayRaw(
        string $inputName,
        string $type,
        array $values,
        array $valuesEncoded
    ) {
        $this->fixedLengthData[$inputName] = [
            'name' => $inputName,
            'type' => $type,
            'values_provided' => $values,
            'values_encoded' => $valuesEncoded,
        ];
    }

    protected function addDynamicLengthBytesRaw(
        string $inputName,
        string $type,
        $value,
        array $valueEncoded,
        int $length
    ) {
        $positionLength = ceil($length / 64);

        $this->dynamicLengthData[$inputName] = [
            'name' => $inputName,
            'type' => $type,
            'is_array' => false,
            'position' => $this->dynamicPositionFor($positionLength),
            'length' => $length,
            'values_provided' => $value,
            'values_encoded' => $valueEncoded,
        ];
    }

    protected function addFixedLengthBytesRaw(string $inputName, string $type, $value, string $valueEncoded)
    {
        $this->data[$inputName] = [
            'name' => $inputName,
            'type' => $type,
            'value_provided' => $value,
            'value_encoded' => $valueEncoded,
        ];
    }

    protected function addStringRaw(string $inputName, $value, array $valueEncoded, string $length)
    {
        $positionLength = ceil($length / 32);

        $this->dynamicLengthData[$inputName] = [
            'name' => $inputName,
            'type' => 'string',
            'position' => $this->dynamicPositionFor($positionLength),
            'length' => $length,
            'values_provided' => $value,
            'values_encoded' => $valueEncoded,
        ];
    }

    private function addFixedLengthDataToOutput(array $output, array $item): array
    {
        $name = $item['name'];
        $values = $item['values_provided'];
        $valuesEncoded = $item['values_encoded'];
        $type = $item['type'];

        foreach ($values as $i => $value) {
            $encoded = $valuesEncoded[$i];
            $output[] = [
                'name' => $name . '[' . $i . '] value',
                'type' => $type,
                'value_provided' => $value,
                'value_encoded' => $encoded,
            ];
        }

        return $output;
    }

    private function addDynamicLengthDataToOutput(array $output, array $item): array
    {
        $name = $item['name'];
        $position = $item['position'];
        $dataValuesEncoded = $item['values_encoded'];

        $output[] = [
            'name' => $name . ' data position',
            'value' => $position,
            'value_encoded' => HexConverter::uintToHex($position, 64),
            'position_string_index' => $position * 2,
            'position_chunk_index' => ($position * 2) / 64,
            'data_value_encoded' => $dataValuesEncoded,
        ];

        return $output;
    }

    private function dynamicPositionFor(int $length): string
    {
        $value = $this->dynamicDataPosition;
        $this->dynamicDataPosition += ($length * 32) + 32;

        return $value;
    }
}
