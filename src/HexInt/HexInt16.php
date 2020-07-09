<?php

namespace Enjin\BlockchainTools\HexInt;

class HexInt16 extends BaseHexInt
{
    public const LENGTH = 4;
    public const HEX_MIN = '8000';
    public const HEX_MAX = '7fff';
    public const INT_MIN = '-32768';
    public const INT_MAX = '32767';
    public const SIZE = '65535';

    public function toInt24(): string
    {
        return $this->convertUpTo($this->value, HexInt24::LENGTH);
    }

    public function toInt32(): string
    {
        return $this->convertUpTo($this->value, HexInt32::LENGTH);
    }

    public function toInt40(): string
    {
        return $this->convertUpTo($this->value, HexInt40::LENGTH);
    }

    public function toInt48(): string
    {
        return $this->convertUpTo($this->value, HexInt48::LENGTH);
    }

    public function toInt56(): string
    {
        return $this->convertUpTo($this->value, HexInt56::LENGTH);
    }

    public function toInt64(): string
    {
        return $this->convertUpTo($this->value, HexInt64::LENGTH);
    }

    public function toInt72(): string
    {
        return $this->convertUpTo($this->value, HexInt72::LENGTH);
    }

    public function toInt80(): string
    {
        return $this->convertUpTo($this->value, HexInt80::LENGTH);
    }

    public function toInt88(): string
    {
        return $this->convertUpTo($this->value, HexInt88::LENGTH);
    }

    public function toInt96(): string
    {
        return $this->convertUpTo($this->value, HexInt96::LENGTH);
    }

    public function toInt104(): string
    {
        return $this->convertUpTo($this->value, HexInt104::LENGTH);
    }

    public function toInt112(): string
    {
        return $this->convertUpTo($this->value, HexInt112::LENGTH);
    }

    public function toInt120(): string
    {
        return $this->convertUpTo($this->value, HexInt120::LENGTH);
    }

    public function toInt128(): string
    {
        return $this->convertUpTo($this->value, HexInt128::LENGTH);
    }

    public function toInt136(): string
    {
        return $this->convertUpTo($this->value, HexInt136::LENGTH);
    }

    public function toInt144(): string
    {
        return $this->convertUpTo($this->value, HexInt144::LENGTH);
    }

    public function toInt152(): string
    {
        return $this->convertUpTo($this->value, HexInt152::LENGTH);
    }

    public function toInt160(): string
    {
        return $this->convertUpTo($this->value, HexInt160::LENGTH);
    }

    public function toInt168(): string
    {
        return $this->convertUpTo($this->value, HexInt168::LENGTH);
    }

    public function toInt176(): string
    {
        return $this->convertUpTo($this->value, HexInt176::LENGTH);
    }

    public function toInt184(): string
    {
        return $this->convertUpTo($this->value, HexInt184::LENGTH);
    }

    public function toInt192(): string
    {
        return $this->convertUpTo($this->value, HexInt192::LENGTH);
    }

    public function toInt200(): string
    {
        return $this->convertUpTo($this->value, HexInt200::LENGTH);
    }

    public function toInt208(): string
    {
        return $this->convertUpTo($this->value, HexInt208::LENGTH);
    }

    public function toInt216(): string
    {
        return $this->convertUpTo($this->value, HexInt216::LENGTH);
    }

    public function toInt224(): string
    {
        return $this->convertUpTo($this->value, HexInt224::LENGTH);
    }

    public function toInt232(): string
    {
        return $this->convertUpTo($this->value, HexInt232::LENGTH);
    }

    public function toInt240(): string
    {
        return $this->convertUpTo($this->value, HexInt240::LENGTH);
    }

    public function toInt248(): string
    {
        return $this->convertUpTo($this->value, HexInt248::LENGTH);
    }

    public function toInt256(): string
    {
        return $this->convertUpTo($this->value, HexInt256::LENGTH);
    }
}
