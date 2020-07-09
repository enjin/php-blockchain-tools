<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\Concerns;

use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthAddress;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthBool;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthBytes;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthInt;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthString;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\EthUint;

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
}
