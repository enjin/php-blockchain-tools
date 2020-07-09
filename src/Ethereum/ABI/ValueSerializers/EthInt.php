<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers;

use Enjin\BlockchainTools\HexConverter;

class EthInt
{
    protected const MIN = '-57896044618658097711785492504343953926634992332820282019728792003956564819968';
    protected const MAX = '57896044618658097711785492504343953926634992332820282019728792003956564819967';

    public static function encode(string $int)
    {
        return HexConverter::intToHexInt($int, 64);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexIntToInt($hex);
    }
}
