<?php

namespace Enjin\BlockchainTools\HexNumber;

use Enjin\BlockchainTools\HexNumber\HexInt\HexInt104;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt112;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt120;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt128;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt136;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt144;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt152;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt16;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt160;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt168;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt176;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt184;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt192;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt200;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt208;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt216;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt224;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt232;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt24;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt240;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt248;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt256;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt32;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt40;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt48;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt56;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt64;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt72;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt8;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt80;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt88;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt96;
use InvalidArgumentException;

class HexInt
{
    const BIT_SIZE_TO_CLASS = [
        8 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt8',
        16 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt16',
        24 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt24',
        32 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt32',
        40 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt40',
        48 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt48',
        56 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt56',
        64 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt64',
        72 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt72',
        80 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt80',
        88 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt88',
        96 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt96',
        104 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt104',
        112 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt112',
        120 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt120',
        128 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt128',
        136 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt136',
        144 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt144',
        152 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt152',
        160 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt160',
        168 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt168',
        176 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt176',
        184 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt184',
        192 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt192',
        200 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt200',
        208 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt208',
        216 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt216',
        224 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt224',
        232 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt232',
        240 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt240',
        248 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt248',
        256 => 'Enjin\BlockchainTools\HexNumber\HexInt\HexInt256',
    ];

    public static function fromHexIntBitSize(int $bitSize, string $hex)
    {
        if (!array_key_exists($bitSize, static::BIT_SIZE_TO_CLASS)) {
            throw new InvalidArgumentException('Invalid bit size: ' . $bitSize);
        }

        $class = static::BIT_SIZE_TO_CLASS[$bitSize];

        return new $class($hex);
    }

    public static function fromIntBitSize(int $bitSize, string $int)
    {
        if (!array_key_exists($bitSize, static::BIT_SIZE_TO_CLASS)) {
            throw new InvalidArgumentException('Invalid bit size: ' . $bitSize);
        }

        $class = static::BIT_SIZE_TO_CLASS[$bitSize];

        return  $class::fromInt($int);
    }

    public static function fromHexInt8(string $int8): HexInt8
    {
        return new HexInt8($int8);
    }

    public static function fromHexInt16(string $int16): HexInt16
    {
        return new HexInt16($int16);
    }

    public static function fromHexInt24(string $int24): HexInt24
    {
        return new HexInt24($int24);
    }

    public static function fromHexInt32(string $int32): HexInt32
    {
        return new HexInt32($int32);
    }

    public static function fromHexInt40(string $int40): HexInt40
    {
        return new HexInt40($int40);
    }

    public static function fromHexInt48(string $int48): HexInt48
    {
        return new HexInt48($int48);
    }

    public static function fromHexInt56(string $int56): HexInt56
    {
        return new HexInt56($int56);
    }

    public static function fromHexInt64(string $int64): HexInt64
    {
        return new HexInt64($int64);
    }

    public static function fromHexInt72(string $int72): HexInt72
    {
        return new HexInt72($int72);
    }

    public static function fromHexInt80(string $int80): HexInt80
    {
        return new HexInt80($int80);
    }

    public static function fromHexInt88(string $int88): HexInt88
    {
        return new HexInt88($int88);
    }

    public static function fromHexInt96(string $int96): HexInt96
    {
        return new HexInt96($int96);
    }

    public static function fromHexInt104(string $int104): HexInt104
    {
        return new HexInt104($int104);
    }

    public static function fromHexInt112(string $int112): HexInt112
    {
        return new HexInt112($int112);
    }

    public static function fromHexInt120(string $int120): HexInt120
    {
        return new HexInt120($int120);
    }

    public static function fromHexInt128(string $int128): HexInt128
    {
        return new HexInt128($int128);
    }

    public static function fromHexInt136(string $int136): HexInt136
    {
        return new HexInt136($int136);
    }

    public static function fromHexInt144(string $int144): HexInt144
    {
        return new HexInt144($int144);
    }

    public static function fromHexInt152(string $int152): HexInt152
    {
        return new HexInt152($int152);
    }

    public static function fromHexInt160(string $int160): HexInt160
    {
        return new HexInt160($int160);
    }

    public static function fromHexInt168(string $int168): HexInt168
    {
        return new HexInt168($int168);
    }

    public static function fromHexInt176(string $int176): HexInt176
    {
        return new HexInt176($int176);
    }

    public static function fromHexInt184(string $int184): HexInt184
    {
        return new HexInt184($int184);
    }

    public static function fromHexInt192(string $int192): HexInt192
    {
        return new HexInt192($int192);
    }

    public static function fromHexInt200(string $int200): HexInt200
    {
        return new HexInt200($int200);
    }

    public static function fromHexInt208(string $int208): HexInt208
    {
        return new HexInt208($int208);
    }

    public static function fromHexInt216(string $int216): HexInt216
    {
        return new HexInt216($int216);
    }

    public static function fromHexInt224(string $int224): HexInt224
    {
        return new HexInt224($int224);
    }

    public static function fromHexInt232(string $int232): HexInt232
    {
        return new HexInt232($int232);
    }

    public static function fromHexInt240(string $int240): HexInt240
    {
        return new HexInt240($int240);
    }

    public static function fromHexInt248(string $int248): HexInt248
    {
        return new HexInt248($int248);
    }

    public static function fromHexInt256(string $int256): HexInt256
    {
        return new HexInt256($int256);
    }
}
