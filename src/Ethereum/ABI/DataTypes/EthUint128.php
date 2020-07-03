<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint128
{
    public static function encode(string $uInt128)
    {
        return HexConverter::intToHexPrefixed($uInt128, 32);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToUInt($hex);
    }
}
