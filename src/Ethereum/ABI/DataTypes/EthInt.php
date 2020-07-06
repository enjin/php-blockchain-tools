<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthInt
{
    public static function encode(string $int)
    {
        return HexConverter::intToHexInt($int, 64);
    }

    public static function decode(string $hex)
    {
        $first2 = substr($hex, 0, 2);
        $isNegative = $first2 === 'ff';
        $hex = substr($hex, 2);

        $int = HexConverter::hexToUInt($hex);

        if ($isNegative) {
            $int = -$int;
        }

        return $int;
    }
}
