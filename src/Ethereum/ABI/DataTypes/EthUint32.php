<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint32
{
    public static function encode(string $uInt32)
    {
        return HexConverter::intToHexPrefixed($uInt32, 8);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToUInt($hex);
    }
}
