<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthString
{
    public static function encode(string $string)
    {
        $stringLength = strlen($string);
        $stringLengthEncoded = HexConverter::intToHexPrefixed($stringLength);

        return $stringLengthEncoded . HexConverter::stringToHex($string, 64);
    }

    public static function decode(string $hex)
    {
        $value = HexConverter::prefix($hex);

        $stringLengthHex = substr($value, 0, 66);
        $stringLength = HexConverter::intToHex($stringLengthHex);

        $value = substr($value, 66);
        $value = HexConverter::hexToString($value);

        return substr($value, 0, $stringLength);
    }
}
