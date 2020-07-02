<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint256
{
    public static function encode(string $uInt256)
    {
        return HexConverter::intToHexPrefixed($uInt256, 64);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToInt($hex);
    }
}
