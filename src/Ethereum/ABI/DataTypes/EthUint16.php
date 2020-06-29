<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint16
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '65535';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffff';

    public static function encode(string $uInt16)
    {
        return HexConverter::intToHexPrefixed($uInt16, 4);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToInt($hex);
    }
}
