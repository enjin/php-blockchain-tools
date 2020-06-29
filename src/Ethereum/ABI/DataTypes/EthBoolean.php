<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthBoolean
{
    public static function encode(bool $value)
    {
        return $value ? '0x1' : '0x0';
    }

    public static function decode(string $value)
    {
        return (bool) HexConverter::hexToInt($value);
    }
}
