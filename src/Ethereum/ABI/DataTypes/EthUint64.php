<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint64
{
    public static function encode(string $uInt64)
    {
        return HexConverter::intToHexPrefixed($uInt64, 16);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToUInt($hex);
    }
}
