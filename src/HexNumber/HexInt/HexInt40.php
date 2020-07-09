<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt40 extends BaseHexInt
{
    public const LENGTH = 10;
    public const HEX_MIN = '8000000000';
    public const HEX_MAX = '7fffffffff';
    public const INT_MIN = '-549755813888';
    public const INT_MAX = '549755813887';
    public const SIZE = '1099511627775';

    public function toHexInt48(): string
    {
        return $this->convertUpTo($this->value, HexInt48::LENGTH);
    }

    public function toHexInt56(): string
    {
        return $this->convertUpTo($this->value, HexInt56::LENGTH);
    }

    public function toHexInt64(): string
    {
        return $this->convertUpTo($this->value, HexInt64::LENGTH);
    }

    public function toHexInt72(): string
    {
        return $this->convertUpTo($this->value, HexInt72::LENGTH);
    }

    public function toHexInt80(): string
    {
        return $this->convertUpTo($this->value, HexInt80::LENGTH);
    }

    public function toHexInt88(): string
    {
        return $this->convertUpTo($this->value, HexInt88::LENGTH);
    }

    public function toHexInt96(): string
    {
        return $this->convertUpTo($this->value, HexInt96::LENGTH);
    }

    public function toHexInt104(): string
    {
        return $this->convertUpTo($this->value, HexInt104::LENGTH);
    }

    public function toHexInt112(): string
    {
        return $this->convertUpTo($this->value, HexInt112::LENGTH);
    }

    public function toHexInt120(): string
    {
        return $this->convertUpTo($this->value, HexInt120::LENGTH);
    }

    public function toHexInt128(): string
    {
        return $this->convertUpTo($this->value, HexInt128::LENGTH);
    }

    public function toHexInt136(): string
    {
        return $this->convertUpTo($this->value, HexInt136::LENGTH);
    }

    public function toHexInt144(): string
    {
        return $this->convertUpTo($this->value, HexInt144::LENGTH);
    }

    public function toHexInt152(): string
    {
        return $this->convertUpTo($this->value, HexInt152::LENGTH);
    }

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
