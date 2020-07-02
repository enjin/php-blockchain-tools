<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint16
{
    public static function encode(string $uInt16)
    {
        return HexConverter::intToHexPrefixed($uInt16, 4);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToInt($hex);
    }
}
