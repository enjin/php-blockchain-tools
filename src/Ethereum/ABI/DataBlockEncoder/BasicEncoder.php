<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataBlockEncoder;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockEncoder;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt160;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;

class BasicEncoder extends DataBlockEncoder
{
    public function addString(ContractFunctionValueType $valueType, $value)
    {
        $length = strlen($value);
        $hex = HexConverter::stringToHex($value);

        $valueEncoded = str_split($hex, 64);
        $last = array_pop($valueEncoded);
        $valueEncoded[] = HexUInt256::padRight($last);

        $this->addStringRaw(
            $valueType->name(),
            $value,
            $valueEncoded,
            $length
        );
    }

    public function addDynamicLengthBytes(ContractFunctionValueType $valueType, $value)
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException('array of bytes must be provided when encoding with this serializer, got ' . gettype($valueType));
        }

        $length = count($value);

        if ($value) {
            $valueEncoded = HexConverter::bytesToHex($value);
        } else {
            $valueEncoded = HexUInt256::HEX_MIN;
        }

        $valueEncoded = str_split($valueEncoded, 64);
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

    public function add(ContractFunctionValueType $valueType, $value)
    {
        $valueEncoded = $value;
        $dataType = $valueType->dataType();
        if ($dataType->aliasedFrom() === 'bool') {
            $valueEncoded = HexUInt256::fromUInt($value ? '1' : '0')->toHex();
        }

        if ($dataType->baseType() === 'address') {
            $valueEncoded = HexConverter::unPrefix($value);
            $valueEncoded = HexUInt160::fromHex($valueEncoded)->toHexUInt256();
        }

        $this->addRaw(
            $valueType->name(),
            $valueType->type(),
            $value,
            $valueEncoded
        );
    }
}
