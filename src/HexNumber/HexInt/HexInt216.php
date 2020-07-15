<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt216 extends BaseHexInt
{
    public const BIT_SIZE = 216;
    public const HEX_LENGTH = 54;
    public const HEX_MIN = '800000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-52656145834278593348959013841835216159447547700274555627155488768';
    public const INT_MAX = '52656145834278593348959013841835216159447547700274555627155488767';
    public const INT_SIZE = '105312291668557186697918027683670432318895095400549111254310977535';

    public function toHexInt216(): string
    {
        return $this->value;
    }

    public function toHexInt224(): string
    {
        return $this->convertUpTo(224);
    }

    public function toHexInt232(): string
    {
        return $this->convertUpTo(232);
    }

    public function toHexInt240(): string
    {
        return $this->convertUpTo(240);
    }

    public function toHexInt248(): string
    {
        return $this->convertUpTo(248);
    }

    public function toHexInt256(): string
    {
        return $this->convertUpTo(256);
    }
}
