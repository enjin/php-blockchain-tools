<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt216 extends BaseHexInt
{
    public const HEX_LENGTH = 54;
    public const HEX_MIN = '800000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-52656145834278593348959013841835216159447547700274555627155488768';
    public const INT_MAX = '52656145834278593348959013841835216159447547700274555627155488767';
    public const INT_SIZE = '105312291668557186697918027683670432318895095400549111254310977535';

    public function toHexInt224(): string
    {
        return $this->convertUpTo($this->value, HexInt224::HEX_LENGTH);
    }

    public function toHexInt232(): string
    {
        return $this->convertUpTo($this->value, HexInt232::HEX_LENGTH);
    }

    public function toHexInt240(): string
    {
        return $this->convertUpTo($this->value, HexInt240::HEX_LENGTH);
    }

    public function toHexInt248(): string
    {
        return $this->convertUpTo($this->value, HexInt248::HEX_LENGTH);
    }

    public function toHexInt256(): string
    {
        return $this->convertUpTo($this->value, HexInt256::HEX_LENGTH);
    }
}
