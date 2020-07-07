<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers;

use Enjin\BlockchainTools\HexConverter;

class EthInt
{
    public static function encode(string $int)
    {
        return HexConverter::intToHexInt($int, 64);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexIntToInt($hex);
    }
}
