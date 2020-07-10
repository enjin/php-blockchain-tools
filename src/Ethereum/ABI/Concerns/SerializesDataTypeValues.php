<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\Concerns;

use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthBool;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthBytes;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthString;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexInt;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt256;
use Enjin\BlockchainTools\HexNumber\HexUInt;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt160;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;

trait SerializesDataTypeValues
{
    public function encodeArrayValues(array $values): array
    {
        return array_map(function ($val) {
            return $this->encodeBaseType($val);
        }, $values);
    }

    public function encodeBaseType($value)
    {
        $baseType = $this->baseType();

        if ($baseType === 'int') {
            $int = HexInt::fromIntBitSize($this->bitSize(), $value);

            return $int->toHexInt256();
        }

        if ($baseType === 'uint') {
            if ($this->aliasedFrom() === 'bool') {
                return EthBool::encode($value);
            }

            $uint = HexUInt::fromUIntBitSize($this->bitSize(), $value);

            return $uint->toHexUInt256();
        }

        if ($baseType === 'address') {
            $value = HexConverter::unPrefix($value);
            $uint = (new HexUInt160($value));

            return $uint->toHexUInt256();
        }

        if ($baseType === 'bytes') {
            if (!$value) {
                $value = [];
            }

            return EthBytes::encode($value);
        }

        if ($baseType === 'bool') {
            return EthBool::encode($value);
        }

        if ($baseType === 'string') {
            EthString::encode($value);
        }
    }

    public function decodeArrayValues(array $values): array
    {
        return array_map(function ($val) {
            return $this->decodeBaseType($val);
        }, $values);
    }

    public function decodeBaseType($value)
    {
        $baseType = $this->baseType();

        if ($baseType === 'int') {
            $int = new HexInt256($value);

            return $int->toDecimal();
        }

        if ($baseType === 'uint') {
            $uint = new HexUInt256($value);

            if ($this->bitSize() !== 256) {
                $uint = $uint->convertDownToBottom($this->bitSize());
                $uint = HexUInt::fromHexUIntBitSize($this->bitSize(), $uint);
            }

            if ($this->aliasedFrom() === 'bool') {
                return (bool) $uint->toDecimal();
            }

            return $uint->toDecimal();
        }

        if ($baseType === 'address') {
            $uint = new HexUInt256($value);
            return $uint->toHexUInt160Bottom();
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
}
