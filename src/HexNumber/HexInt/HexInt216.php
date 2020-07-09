<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt216 extends BaseHexInt
{
    public const LENGTH = 54;
    public const HEX_MIN = '800000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-52656145834278593348959013841835216159447547700274555627155488768';
    public const INT_MAX = '52656145834278593348959013841835216159447547700274555627155488767';
    public const SIZE = '105312291668557186697918027683670432318895095400549111254310977535';

    public function toHexInt224(): string
    {
        return $this->convertUpTo($this->value, HexInt224::LENGTH);
    }

    public function toHexInt232(): string
    {
        return $this->convertUpTo($this->value, HexInt232::LENGTH);
    }

    public function toHexInt240(): string
    {
        return $this->convertUpTo($this->value, HexInt240::LENGTH);
    }

    public function toHexInt248(): string
    {
        return $this->convertUpTo($this->value, HexInt248::LENGTH);
    }

    public function toHexInt256(): string
    {
        return $this->convertUpTo($this->value, HexInt256::LENGTH);
    }
}
