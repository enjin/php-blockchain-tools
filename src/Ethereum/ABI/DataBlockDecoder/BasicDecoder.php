<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;

class BasicDecoder extends DataBlockDecoder
{
    public function addString(ContractFunctionValueType $valueType, string $value)
    {
        $value = $valueType->dataType()->decodeBaseType($value);

        parent::addString($valueType, $value);
    }

    public function addDynamicLengthBytes(ContractFunctionValueType $valueType, $value)
    {
        $value = $valueType->dataType()->decodeBaseType($value);

        parent::addDynamicLengthBytes($valueType, $value);
    }

    public function add(ContractFunctionValueType $valueType, $value)
    {
        $dataType = $valueType->dataType();
        if ($dataType->aliasedFrom() === 'bool') {
            $value = $dataType->decodeBaseType($value);
        }

        if ($dataType->baseType() === 'address') {
            $value = HexUInt256::fromHex($value)->toHexUInt160Bottom();
        }

        parent::add($valueType, $value);
    }
}
