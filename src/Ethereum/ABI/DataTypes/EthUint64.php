<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint64
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '18446744073709551615';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffffffffffff';

    public static function encode(string $uInt64)
    {
        return HexConverter::intToHexPrefixed($uInt64, 16);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToInt($hex);
    }
}
