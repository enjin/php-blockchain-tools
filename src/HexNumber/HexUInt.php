<?php

namespace Enjin\BlockchainTools\HexNumber;

use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt104;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt112;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt120;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt128;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt136;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt144;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt152;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt16;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt160;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt168;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt176;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt184;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt192;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt200;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt208;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt216;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt224;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt232;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt24;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt240;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt248;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt32;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt40;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt48;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt56;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt64;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt72;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt8;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt80;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt88;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt96;
use InvalidArgumentException;

class HexUInt
{
    const BIT_SIZE_TO_CLASS = [
        8 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt8',
        16 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt16',
        24 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt24',
        32 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt32',
        40 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt40',
        48 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt48',
        56 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt56',
        64 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt64',
        72 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt72',
        80 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt80',
        88 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt88',
        96 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt96',
        104 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt104',
        112 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt112',
        120 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt120',
        128 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt128',
        136 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt136',
        144 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt144',
        152 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt152',
        160 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt160',
        168 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt168',
        176 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt176',
        184 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt184',
        192 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt192',
        200 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt200',
        208 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt208',
        216 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt216',
        224 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt224',
        232 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt232',
        240 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt240',
        248 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt248',
        256 => 'Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256',
    ];

    public static function fromHexUIntBitSize(int $bitSize, string $hex)
    {
        if (!array_key_exists($bitSize, static::BIT_SIZE_TO_CLASS)) {
            throw new InvalidArgumentException('Invalid bit size: ' . $bitSize);
        }

        $class = static::BIT_SIZE_TO_CLASS[$bitSize];

        return new $class($hex);
    }

    public static function fromHexUInt8(string $uInt8): HexUInt8
    {
        return new HexUInt8($uInt8);
    }

    public static function fromHexUInt16(string $uInt16): HexUInt16
    {
        return new HexUInt16($uInt16);
    }

    public static function fromHexUInt24(string $uInt24): HexUInt24
    {
        return new HexUInt24($uInt24);
    }

    public static function fromHexUInt32(string $uInt32): HexUInt32
    {
        return new HexUInt32($uInt32);
    }

    public static function fromHexUInt40(string $uInt40): HexUInt40
    {
        return new HexUInt40($uInt40);
    }

    public static function fromHexUInt48(string $uInt48): HexUInt48
    {
        return new HexUInt48($uInt48);
    }

    public static function fromHexUInt56(string $uInt56): HexUInt56
    {
        return new HexUInt56($uInt56);
    }

    public static function fromHexUInt64(string $uInt64): HexUInt64
    {
        return new HexUInt64($uInt64);
    }

    public static function fromHexUInt72(string $uInt72): HexUInt72
    {
        return new HexUInt72($uInt72);
    }

    public static function fromHexUInt80(string $uInt80): HexUInt80
    {
        return new HexUInt80($uInt80);
    }

    public static function fromHexUInt88(string $uInt88): HexUInt88
    {
        return new HexUInt88($uInt88);
    }

    public static function fromHexUInt96(string $uInt96): HexUInt96
    {
        return new HexUInt96($uInt96);
    }

    public static function fromHexUInt104(string $uInt104): HexUInt104
    {
        return new HexUInt104($uInt104);
    }

    public static function fromHexUInt112(string $uInt112): HexUInt112
    {
        return new HexUInt112($uInt112);
    }

    public static function fromHexUInt120(string $uInt120): HexUInt120
    {
        return new HexUInt120($uInt120);
    }

    public static function fromHexUInt128(string $uInt128): HexUInt128
    {
        return new HexUInt128($uInt128);
    }

    public static function fromHexUInt136(string $uInt136): HexUInt136
    {
        return new HexUInt136($uInt136);
    }

    public static function fromHexUInt144(string $uInt144): HexUInt144
    {
        return new HexUInt144($uInt144);
    }

    public static function fromHexUInt152(string $uInt152): HexUInt152
    {
        return new HexUInt152($uInt152);
    }

    public static function fromHexUInt160(string $uInt160): HexUInt160
    {
        return new HexUInt160($uInt160);
    }

    public static function fromHexUInt168(string $uInt168): HexUInt168
    {
        return new HexUInt168($uInt168);
    }

    public static function fromHexUInt176(string $uInt176): HexUInt176
    {
        return new HexUInt176($uInt176);
    }

    public static function fromHexUInt184(string $uInt184): HexUInt184
    {
        return new HexUInt184($uInt184);
    }

    public static function fromHexUInt192(string $uInt192): HexUInt192
    {
        return new HexUInt192($uInt192);
    }

    public static function fromHexUInt200(string $uInt200): HexUInt200
    {
        return new HexUInt200($uInt200);
    }

    public static function fromHexUInt208(string $uInt208): HexUInt208
    {
        return new HexUInt208($uInt208);
    }

    public static function fromHexUInt216(string $uInt216): HexUInt216
    {
        return new HexUInt216($uInt216);
    }

    public static function fromHexUInt224(string $uInt224): HexUInt224
    {
        return new HexUInt224($uInt224);
    }

    public static function fromHexUInt232(string $uInt232): HexUInt232
    {
        return new HexUInt232($uInt232);
    }

    public static function fromHexUInt240(string $uInt240): HexUInt240
    {
        return new HexUInt240($uInt240);
    }

    public static function fromHexUInt248(string $uInt248): HexUInt248
    {
        return new HexUInt248($uInt248);
    }

    public static function fromHexUInt256(string $uInt256): HexUInt256
    {
        return new HexUInt256($uInt256);
    }
}
