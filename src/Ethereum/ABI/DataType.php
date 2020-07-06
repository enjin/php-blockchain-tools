<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\DataTypes\EthBoolean;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexUIntConverter;

class DataType
{
    /**
     * @var string
     */
    protected $baseType;

    /**
     * @var int|string
     */
    protected $length;

    /**
     * @var int|string
     */
    protected $arrayLength;

    /**
     * @var string
     */
    protected $rawType;

    /**
     * @var null
     */
    protected $decimalPrecision;

    /**
     * @var string|null
     */
    protected $aliasedFrom;

    public function __construct(array $data)
    {
        $defaults = [
            'rawType' => null,
            'baseType' => null,
            'length' => null,
            'arrayLength' => null,
            'decimalPrecision' => null,
            'aliasedFrom' => null,
        ];
        $data = array_merge($defaults, $data);

        $this->setData(
            $data['rawType'],
            $data['baseType'],
            $data['length'],
            $data['arrayLength'],
            $data['decimalPrecision'],
            $data['aliasedFrom']
        );
    }

    public function rawType(): string
    {
        return $this->rawType;
    }

    public function baseType(): string
    {
        return $this->baseType;
    }

    public function length()
    {
        return $this->length;
    }

    public function arrayLength()
    {
        return $this->arrayLength;
    }

    public function isArray(): bool
    {
        return $this->arrayLength !== null;
    }

    public function isDynamicLengthArray()
    {
        return $this->isArray() && $this->arrayLength() === 'dynamic';
    }

    public function isFixedLengthArray()
    {
        return $this->isArray() && $this->arrayLength() !== 'dynamic';
    }

    public function decimalPrecision(): ?int
    {
        return $this->decimalPrecision;
    }

    public function aliasedFrom(): ?string
    {
        return $this->aliasedFrom;
    }

    public function encodeBaseType($value)
    {
        $baseType = $this->baseType();

        if ($baseType === 'int') {
            return HexConverter::intToHexInt($value, 64);
        }

        if ($baseType === 'uint') {
            if ($this->aliasedFrom() === 'bool') {
                $value = (int) $value;
            }

            return HexConverter::intToHexUInt($value, 64);
        }

        if ($baseType === 'address') {
            return HexUIntConverter::padToUInt256($value);
        }

        if ($baseType === 'bytes') {
            $hex = null;
            if ($value) {
                return HexConverter::bytesToHex($value);
            }

            return HexConverter::intToHexUInt('0', 64);
        }

        if ($baseType === 'bool') {
            return EthBoolean::encode($value);
        }

        if ($baseType === 'string') {
            if ($value) {
                return HexConverter::stringToHex($value, 64);
            }

            return HexConverter::intToHexUInt('0', 64);
        }
    }

    public function encodeArrayValues(array $values): array
    {
        return array_map(function ($val) {
            return $this->encodeBaseType($val);
        }, $values);
    }

    protected function setData(
        string $rawType,
        string $baseType,
        $length = null,
        $arrayLength = null,
        int $decimalPrecision = null,
        string $aliasedFrom = null
    ) {
        $this->rawType = $rawType;
        $this->baseType = $baseType;
        $this->length = $length;
        $this->arrayLength = $arrayLength;
        $this->decimalPrecision = $decimalPrecision;
        $this->aliasedFrom = $aliasedFrom;
    }
}
