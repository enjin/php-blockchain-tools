<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\Concerns;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexInt;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt256;
use Enjin\BlockchainTools\HexNumber\HexUInt;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt160;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;
use InvalidArgumentException;

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
                $value = $value ? '1' : '0';

                return HexUInt256::fromUInt($value)->toHex();
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
            if ($value) {
                return HexConverter::bytesToHex($value);
            }

            return HexUInt256::HEX_MIN;
        }

        if ($baseType === 'string') {
            if ($value) {
                return HexConverter::stringToHex($value, 64);
            }

            return HexUInt256::HEX_MIN;
        }

        throw new InvalidArgumentException('Invalid base type: ' . $baseType);
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
            if ($this->bitSize() !== 256) {
                $int = $int->convertDownToBottom($this->bitSize());
                $int = HexInt::fromHexIntBitSize($this->bitSize(), $int);
            }

            return $int->toDecimal();
        }

        if ($baseType === 'uint') {
            $uint = new HexUInt256($value);

            if ($this->aliasedFrom() === 'bool') {
                return (bool) $uint->toDecimal();
            }

            if ($this->bitSize() !== 256) {
                $uint = $uint->convertDownToBottom($this->bitSize());
                $uint = HexUInt::fromHexUIntBitSize($this->bitSize(), $uint);
            }

            return $uint->toDecimal();
        }

        if ($baseType === 'address') {
            $uint = new HexUInt256($value);

            return $uint->toHexUInt160Bottom();
        }

        if ($baseType === 'bytes') {
            return HexConverter::hexToBytes($value);
        }

        if ($baseType === 'string') {
            return HexConverter::hexToString($value);
        }

        throw new InvalidArgumentException('Invalid base type: ' . $baseType);
    }
}
