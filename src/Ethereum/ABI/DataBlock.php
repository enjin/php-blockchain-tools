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

    public function add(ContractFunctionValueType $valueType, $value)
    {
        $valueEncoded = $valueType->dataType()->encodeBaseType($value);

        $this->addRaw(
            $valueType->name(),
            $valueType->type(),
            $valueEncoded,
            $value
        );
    }

    public function addRaw(string $inputName, string $type, string $valueEncoded, $valueDecoded)
    {
        $this->data[] = [
            'name' => $inputName,
            'type' => $type,
            'value' => $valueEncoded,
            'value_decoded' => $valueDecoded,
        ];
    }

    public function addFixedLengthArray(ContractFunctionValueType $valueType, array $values)
    {
        $valueEncoded = $valueType->dataType()->encodeArrayValues($values);

        $this->addFixedLengthArrayRaw(
            $valueType->name(),
            $valueType->type(),
            $valueEncoded,
            $values
        );
    }

    public function addFixedLengthArrayRaw(string $inputName, string $type, array $valuesEncoded, array $valuesDecoded)
    {
        $this->fixedLengthData[] = [
            'name' => $inputName,
            'type' => $type,
            'values' => $valuesEncoded,
            'values_decoded' => $valuesDecoded,
        ];
    }

    public function addDynamicLengthArray(ContractFunctionValueType $valueType, array $values)
    {
        $valueEncoded = $valueType->dataType()->encodeArrayValues($values);

        $this->addDynamicLengthArrayRaw(
            $valueType->name(),
            $valueType->type(),
            $valueEncoded,
            $values
        );
    }

    public function addDynamicLengthArrayRaw(
        string $inputName,
        string $type,
        array $valuesEncoded,
        array $valuesDecoded
    ) {
        $length = count($valuesEncoded);

        if (!$valuesEncoded) {
            $length = 0;
        }
        $this->dynamicLengthData[] = [
            'name' => $inputName,
            'is_array' => true,
            'type' => $type,
            'position' => $this->dynamicPositionFor($length),
            'length' => $length,
            'values' => $valuesEncoded,
            'values_decoded' => $valuesDecoded,
        ];
    }

    public function addDynamicLengthBytes(ContractFunctionValueType $valueType, array $value)
    {
        $valueEncoded = $valueType->dataType()->encodeBaseType($value);

        $length = count($value);

        $this->addDynamicLengthBytesRaw(
            $valueType->name(),
            $valueType->type(),
            $valueEncoded,
            $value,
            $length
        );
    }

    public function addDynamicLengthBytesRaw(
        string $inputName,
        string $type,
        ?string $valueEncoded,
        $valueDecoded,
        int $length
    ) {
        $positionLength = ceil($length / 64);

        $values = str_split($valueEncoded, 64);

        $last = array_pop($values);
        $values[] = HexUInt256::padRight($last);

        $this->dynamicLengthData[] = [
            'name' => $inputName,
            'type' => $type,
            'is_array' => false,
            'position' => $this->dynamicPositionFor($positionLength),
            'length' => $length,
            'values' => $values,
            'values_decoded' => $valueDecoded,
        ];
    }

    public function addString(ContractFunctionValueType $valueType, string $value)
    {
        $length = strlen($value);
        $valueEncoded = $valueType->dataType()->encodeBaseType($value);

        $this->addStringRaw(
            $valueType->name(),
            $valueEncoded,
            $value,
            $length
        );
    }

    public function addStringRaw(string $inputName, string $value, string $valueDecoded, string $length)
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
            'values_decoded' => $valueDecoded,
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
            $valuesDecoded = $item['values_decoded'];
            $type = $item['type'];

            foreach ($values as $i => $value) {
                $decoded = null;
                if (!in_array($type, ['string', 'bytes'])) {
                    $decoded = $valuesDecoded[$i];
                }
                $output[] = [
                    'name' => $name . '[' . $i . '] value',
                    'type' => $type,
                    'value_decoded' => $decoded,
                    'value' => $value,
                ];
            }
        }

        foreach ($this->dynamicLengthData as $item) {
            $name = $item['name'];
            $position = $item['position'];

            $output[] = [
                'name' => $name . ' data position',
                'value_decoded' => $position,
                'position_string_index' => $position * 2,
                'position_chunk_index' => ($position * 2) / 64,
                'value' => HexConverter::intToHexUInt($position, 64),
            ];
        }

        foreach ($this->dynamicLengthData as $item) {
            $name = $item['name'];
            $values = $item['values'];
            $valuesDecoded = $item['values_decoded'];
            $length = $item['length'];
            $type = $item['type'];

            if ($type === 'bytes' || $type === 'string') {
                $output[] = [
                    'name' => "{$name} length: {$length}",
                    'type' => $type,
                    'value_decoded' => $length,
                    'length_hex_string' => $length * 2,
                    'length_chunk_size' => ($length * 2) / 64,
                    'value' => HexConverter::intToHexUInt($length, 64),
                ];

                foreach ($values as $i => $value) {
                    $decoded = null;
                    if (!in_array($type, ['string', 'bytes'])) {
                        $decoded = $valuesDecoded[$i] ?? null;
                    }

                    $output[] = [
                        'name' => $name . ' value chunk[' . $i . ']',
                        'type' => $type,
                        'value_decoded' => $decoded,
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
                        'value_decoded' => $valuesDecoded[$i],
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
