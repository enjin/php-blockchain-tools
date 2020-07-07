<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers;

use Enjin\BlockchainTools\HexConverter;

class EthString
{
    public static function encode(string $string)
    {
        if ($string) {
            return HexConverter::stringToHex($string, 64);
        }

        return HexConverter::intToHexUInt('0', 64);
    }

    public static function decode(string $hex)
    {
        $value = HexConverter::prefix($hex);

        $stringLengthHex = substr($value, 0, 66);
        $stringLength = HexConverter::intToHexInt($stringLengthHex);

        $value = substr($value, 66);
        $value = HexConverter::hexToString($value);

        return substr($value, 0, $stringLength);
    }
}
