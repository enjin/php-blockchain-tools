<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthAddress;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthBool;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthBytes;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthInt;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthString;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthUint;

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
            return EthInt::encode($value);
        }

        if ($baseType === 'uint') {
            if ($this->aliasedFrom() === 'bool') {
                $value = (int) $value;
            }

            return EthUint::encode($value);
        }

        if ($baseType === 'address') {
            return EthAddress::encode($value);
        }

        if ($baseType === 'bytes') {
            if (!$value) {
                $value = [];
            }
            EthBytes::encode($value);
        }

        if ($baseType === 'bool') {
            return EthBool::encode($value);
        }

        if ($baseType === 'string') {
            EthString::encode($value);
        }
    }

    public function encodeArrayValues(array $values): array
    {
        return array_map(function ($val) {
            return $this->encodeBaseType($val);
        }, $values);
    }

    public function decodeBaseType($value)
    {
        $baseType = $this->baseType();

        if ($baseType === 'int') {
            return EthInt::decode($value);
        }

        if ($baseType === 'uint') {
            if ($this->aliasedFrom() === 'bool') {
                return (bool) EthUint::decode($value);
            }

            return EthUint::decode($value);
        }

        if ($baseType === 'address') {
            return EthAddress::decode($value);
        }

        if ($baseType === 'bytes') {
            return EthBytes::decode($value);
        }

        if ($baseType === 'bool') {
            return EthBool::decode($value);
        }

        if ($baseType === 'string') {
            return EthString::decode($value);
        }
    }

    public function decodeArrayValues(array $values): array
    {
        return array_map(function ($val) {
            return $this->decodeBaseType($val);
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
