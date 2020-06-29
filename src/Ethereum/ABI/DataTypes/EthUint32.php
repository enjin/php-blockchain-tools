<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint32
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '4294967295';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffff';

    public static function encode(string $uInt32)
    {
        return HexConverter::intToHexPrefixed($uInt32, 8);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToInt($hex);
    }
}
