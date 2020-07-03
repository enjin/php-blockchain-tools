<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint8
{
    public static function encode(string $uInt8)
    {
        return HexConverter::intToHexPrefixed($uInt8, 2);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToUInt($hex);
    }
}
