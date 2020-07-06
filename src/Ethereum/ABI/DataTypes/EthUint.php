<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint
{
    public static function encode(string $int)
    {
        return HexConverter::intToHexUInt($int, 64);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToUInt($hex);
    }
}
