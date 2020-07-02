<?php

namespace Enjin\BlockchainTools;

use Enjin\BlockchainTools\HexIntConverter\UInt128;
use Enjin\BlockchainTools\HexIntConverter\UInt16;
use Enjin\BlockchainTools\HexIntConverter\UInt256;
use Enjin\BlockchainTools\HexIntConverter\UInt32;
use Enjin\BlockchainTools\HexIntConverter\UInt64;
use Enjin\BlockchainTools\HexIntConverter\UInt8;

class HexUIntConverter
{
    public static function fromUInt8(string $uInt8): UInt8
    {
        return new UInt8($uInt8);
    }

    public static function fromUInt16(string $uInt16): UInt16
    {
        return new UInt16($uInt16);
    }

    public static function fromUInt32(string $uInt32): UInt32
    {
        return new UInt32($uInt32);
    }

    public static function fromUInt64(string $uInt64): UInt64
    {
        return new UInt64($uInt64);
    }

    public static function fromUInt128(string $uInt128): UInt128
    {
        return new UInt128($uInt128);
    }

    public static function fromUInt256(string $uInt256): UInt256
    {
        return new UInt256($uInt256);
    }
}
