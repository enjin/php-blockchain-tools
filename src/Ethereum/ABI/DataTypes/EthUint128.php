<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint128
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '340282366920938463463374607431768211455';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffffffffffffffffffffffffffff';

    public static function encode(string $uInt32)
    {
        return HexConverter::intToHexPrefixed($uInt32, 32);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToInt($hex);
    }
}
