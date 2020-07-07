<?php

namespace Enjin\BlockchainTools;

use Enjin\BlockchainTools\HexUInt\HexUInt104;
use Enjin\BlockchainTools\HexUInt\HexUInt112;
use Enjin\BlockchainTools\HexUInt\HexUInt120;
use Enjin\BlockchainTools\HexUInt\HexUInt128;
use Enjin\BlockchainTools\HexUInt\HexUInt136;
use Enjin\BlockchainTools\HexUInt\HexUInt144;
use Enjin\BlockchainTools\HexUInt\HexUInt152;
use Enjin\BlockchainTools\HexUInt\HexUInt16;
use Enjin\BlockchainTools\HexUInt\HexUInt160;
use Enjin\BlockchainTools\HexUInt\HexUInt168;
use Enjin\BlockchainTools\HexUInt\HexUInt176;
use Enjin\BlockchainTools\HexUInt\HexUInt184;
use Enjin\BlockchainTools\HexUInt\HexUInt192;
use Enjin\BlockchainTools\HexUInt\HexUInt200;
use Enjin\BlockchainTools\HexUInt\HexUInt208;
use Enjin\BlockchainTools\HexUInt\HexUInt216;
use Enjin\BlockchainTools\HexUInt\HexUInt224;
use Enjin\BlockchainTools\HexUInt\HexUInt232;
use Enjin\BlockchainTools\HexUInt\HexUInt24;
use Enjin\BlockchainTools\HexUInt\HexUInt240;
use Enjin\BlockchainTools\HexUInt\HexUInt248;
use Enjin\BlockchainTools\HexUInt\HexUInt256;
use Enjin\BlockchainTools\HexUInt\HexUInt32;
use Enjin\BlockchainTools\HexUInt\HexUInt40;
use Enjin\BlockchainTools\HexUInt\HexUInt48;
use Enjin\BlockchainTools\HexUInt\HexUInt56;
use Enjin\BlockchainTools\HexUInt\HexUInt64;
use Enjin\BlockchainTools\HexUInt\HexUInt72;
use Enjin\BlockchainTools\HexUInt\HexUInt8;
use Enjin\BlockchainTools\HexUInt\HexUInt80;
use Enjin\BlockchainTools\HexUInt\HexUInt88;
use Enjin\BlockchainTools\HexUInt\HexUInt96;

class HexUInt
{
    public static function fromUInt8(string $uInt8): HexUInt8
    {
        return new HexUInt8($uInt8);
    }

    public static function fromUInt16(string $uInt16): HexUInt16
    {
        return new HexUInt16($uInt16);
    }

    public static function fromUInt24(string $uInt24): HexUInt24
    {
        return new HexUInt24($uInt24);
    }

    public static function fromUInt32(string $uInt32): HexUInt32
    {
        return new HexUInt32($uInt32);
    }

    public static function fromUInt40(string $uInt40): HexUInt40
    {
        return new HexUInt40($uInt40);
    }

    public static function fromUInt48(string $uInt48): HexUInt48
    {
        return new HexUInt48($uInt48);
    }

    public static function fromUInt56(string $uInt56): HexUInt56
    {
        return new HexUInt56($uInt56);
    }

    public static function fromUInt64(string $uInt64): HexUInt64
    {
        return new HexUInt64($uInt64);
    }

    public static function fromUInt72(string $uInt72): HexUInt72
    {
        return new HexUInt72($uInt72);
    }

    public static function fromUInt80(string $uInt80): HexUInt80
    {
        return new HexUInt80($uInt80);
    }

    public static function fromUInt88(string $uInt88): HexUInt88
    {
        return new HexUInt88($uInt88);
    }

    public static function fromUInt96(string $uInt96): HexUInt96
    {
        return new HexUInt96($uInt96);
    }

    public static function fromUInt104(string $uInt104): HexUInt104
    {
        return new HexUInt104($uInt104);
    }

    public static function fromUInt112(string $uInt112): HexUInt112
    {
        return new HexUInt112($uInt112);
    }

    public static function fromUInt120(string $uInt120): HexUInt120
    {
        return new HexUInt120($uInt120);
    }

    public static function fromUInt128(string $uInt128): HexUInt128
    {
        return new HexUInt128($uInt128);
    }

    public static function fromUInt136(string $uInt136): HexUInt136
    {
        return new HexUInt136($uInt136);
    }

    public static function fromUInt144(string $uInt144): HexUInt144
    {
        return new HexUInt144($uInt144);
    }

    public static function fromUInt152(string $uInt152): HexUInt152
    {
        return new HexUInt152($uInt152);
    }

    public static function fromUInt160(string $uInt160): HexUInt160
    {
        return new HexUInt160($uInt160);
    }

    public static function fromUInt168(string $uInt168): HexUInt168
    {
        return new HexUInt168($uInt168);
    }

    public static function fromUInt176(string $uInt176): HexUInt176
    {
        return new HexUInt176($uInt176);
    }

    public static function fromUInt184(string $uInt184): HexUInt184
    {
        return new HexUInt184($uInt184);
    }

    public static function fromUInt192(string $uInt192): HexUInt192
    {
        return new HexUInt192($uInt192);
    }

    public static function fromUInt200(string $uInt200): HexUInt200
    {
        return new HexUInt200($uInt200);
    }

    public static function fromUInt208(string $uInt208): HexUInt208
    {
        return new HexUInt208($uInt208);
    }

    public static function fromUInt216(string $uInt216): HexUInt216
    {
        return new HexUInt216($uInt216);
    }

    public static function fromUInt224(string $uInt224): HexUInt224
    {
        return new HexUInt224($uInt224);
    }

    public static function fromUInt232(string $uInt232): HexUInt232
    {
        return new HexUInt232($uInt232);
    }

    public static function fromUInt240(string $uInt240): HexUInt240
    {
        return new HexUInt240($uInt240);
    }

    public static function fromUInt248(string $uInt248): HexUInt248
    {
        return new HexUInt248($uInt248);
    }

    public static function fromUInt256(string $uInt256): HexUInt256
    {
        return new HexUInt256($uInt256);
    }
}
