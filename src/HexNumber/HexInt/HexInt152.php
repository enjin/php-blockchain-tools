<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt152 extends BaseHexInt
{
    public const LENGTH = 38;
    public const HEX_MIN = '80000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-2854495385411919762116571938898990272765493248';
    public const INT_MAX = '2854495385411919762116571938898990272765493247';
    public const SIZE = '5708990770823839524233143877797980545530986495';

    public function toHexInt160(): string
    {
        return $this->convertUpTo($this->value, HexInt160::LENGTH);
    }

    public function toHexInt168(): string
    {
        return $this->convertUpTo($this->value, HexInt168::LENGTH);
    }

    public function toHexInt176(): string
    {
        return $this->convertUpTo($this->value, HexInt176::LENGTH);
    }

    public function toHexInt184(): string
    {
        return $this->convertUpTo($this->value, HexInt184::LENGTH);
    }

    public function toHexInt192(): string
    {
        return $this->convertUpTo($this->value, HexInt192::LENGTH);
    }

    public function toHexInt200(): string
    {
        return $this->convertUpTo($this->value, HexInt200::LENGTH);
    }

    public function toHexInt208(): string
    {
        return $this->convertUpTo($this->value, HexInt208::LENGTH);
    }

    public function toHexInt216(): string
    {
        return $this->convertUpTo($this->value, HexInt216::LENGTH);
    }

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
