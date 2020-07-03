<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthBoolean
{
    public static function encode(bool $value)
    {
        $hex = $value ? '0x1' : '0x0';

        return str_pad($hex, 64, '0', STR_PAD_LEFT);
    }

    public static function decode(string $value)
    {
        return (bool) HexConverter::hexToUInt($value);
    }
}
