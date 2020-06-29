<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint8
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '255';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xff';

    public static function encode(string $uInt8)
    {
        return HexConverter::intToHexPrefixed($uInt8, 2);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToInt($hex);
    }
}
