<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint256
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '115792089237316195423570985008687907853269984665640564039457584007913129639935';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';

    public static function encode(string $uInt32)
    {
        return HexConverter::intToHexPrefixed($uInt32, 64);
    }

    public static function decode(string $hex)
    {
        return HexConverter::hexToInt($hex);
    }
}
