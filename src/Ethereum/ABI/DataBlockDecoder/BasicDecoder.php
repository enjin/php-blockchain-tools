<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;

class BasicDecoder extends DataBlockDecoder
{
    public function addString(ContractFunctionValueType $valueType, string $value)
    {
        $value = HexConverter::hexToString($value);

        parent::addString($valueType, $value);
    }

    public function addDynamicLengthBytes(ContractFunctionValueType $valueType, $value)
    {
        $value = HexConverter::hexToBytes($value);

        parent::addDynamicLengthBytes($valueType, $value);
    }

    public function add(ContractFunctionValueType $valueType, $value)
    {
        $dataType = $valueType->dataType();
        if ($dataType->aliasedFrom() === 'bool') {
            $value = (bool) HexUInt256::fromHex($value)->toDecimal();
        }

        if ($dataType->baseType() === 'address') {
            $value = HexUInt256::fromHex($value)->toHexUInt160Bottom();
        }

        parent::add($valueType, $value);
    }
}
