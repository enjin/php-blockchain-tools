<?php

namespace Enjin\BlockchainTools;

use Enjin\BlockchainTools\HexIntConverter\HexUInt128;
use Enjin\BlockchainTools\HexIntConverter\HexUInt16;
use Enjin\BlockchainTools\HexIntConverter\HexUInt256;
use Enjin\BlockchainTools\HexIntConverter\HexUInt32;
use Enjin\BlockchainTools\HexIntConverter\HexUInt64;
use Enjin\BlockchainTools\HexIntConverter\HexUInt8;

class HexUIntConverter
{
    public static function padToUInt256(string $hex): string
    {
        $hex = HexConverter::unPrefix($hex);

        return str_pad($hex, 64, '0', STR_PAD_LEFT);
    }

    public static function fromUInt8(string $uInt8): HexUInt8
    {
        return new HexUInt8($uInt8);
    }

    public static function fromUInt16(string $uInt16): HexUInt16
    {
        return new HexUInt16($uInt16);
    }

    public static function fromUInt32(string $uInt32): HexUInt32
    {
        return new HexUInt32($uInt32);
    }

    public static function fromUInt64(string $uInt64): HexUInt64
    {
        return new HexUInt64($uInt64);
    }

    public static function fromUInt128(string $uInt128): HexUInt128
    {
        return new HexUInt128($uInt128);
    }

    public static function fromUInt256(string $uInt256): HexUInt256
    {
        return new HexUInt256($uInt256);
    }
}
