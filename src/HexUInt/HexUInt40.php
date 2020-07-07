<?php

namespace Enjin\BlockchainTools\HexUInt;

class HexUInt40 extends BaseHexUInt
{
    public const LENGTH = 10;
    public const HEX_MIN = '0000000000';
    public const HEX_MAX = 'ffffffffff';
    public const INT_MIN = '0';
    public const INT_MAX = '1099511627775';

    public function toUInt8Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt8::LENGTH);
    }

    public function toUInt8Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt8::LENGTH);
    }

    public function toUInt16Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt16::LENGTH);
    }

    public function toUInt16Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt16::LENGTH);
    }

    public function toUInt24Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt24::LENGTH);
    }

    public function toUInt24Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt24::LENGTH);
    }

    public function toUInt32Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt32::LENGTH);
    }

    public function toUInt32Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt32::LENGTH);
    }

    public function toUInt48(): string
    {
        return $this->convertUpTo($this->value, HexUInt48::LENGTH);
    }

    public function toUInt56(): string
    {
        return $this->convertUpTo($this->value, HexUInt56::LENGTH);
    }

    public function toUInt64(): string
    {
        return $this->convertUpTo($this->value, HexUInt64::LENGTH);
    }

    public function toUInt72(): string
    {
        return $this->convertUpTo($this->value, HexUInt72::LENGTH);
    }

    public function toUInt80(): string
    {
        return $this->convertUpTo($this->value, HexUInt80::LENGTH);
    }

    public function toUInt88(): string
    {
        return $this->convertUpTo($this->value, HexUInt88::LENGTH);
    }

    public function toUInt96(): string
    {
        return $this->convertUpTo($this->value, HexUInt96::LENGTH);
    }

    public function toUInt104(): string
    {
        return $this->convertUpTo($this->value, HexUInt104::LENGTH);
    }

    public function toUInt112(): string
    {
        return $this->convertUpTo($this->value, HexUInt112::LENGTH);
    }

    public function toUInt120(): string
    {
        return $this->convertUpTo($this->value, HexUInt120::LENGTH);
    }

    public function toUInt128(): string
    {
        return $this->convertUpTo($this->value, HexUInt128::LENGTH);
    }

    public function toUInt136(): string
    {
        return $this->convertUpTo($this->value, HexUInt136::LENGTH);
    }

    public function toUInt144(): string
    {
        return $this->convertUpTo($this->value, HexUInt144::LENGTH);
    }

    public function toUInt152(): string
    {
        return $this->convertUpTo($this->value, HexUInt152::LENGTH);
    }

    public function toUInt160(): string
    {
        return $this->convertUpTo($this->value, HexUInt160::LENGTH);
    }

    public function toUInt168(): string
    {
        return $this->convertUpTo($this->value, HexUInt168::LENGTH);
    }

    public function toUInt176(): string
    {
        return $this->convertUpTo($this->value, HexUInt176::LENGTH);
    }

    public function toUInt184(): string
    {
        return $this->convertUpTo($this->value, HexUInt184::LENGTH);
    }

    public function toUInt192(): string
    {
        return $this->convertUpTo($this->value, HexUInt192::LENGTH);
    }

    public function toUInt200(): string
    {
        return $this->convertUpTo($this->value, HexUInt200::LENGTH);
    }

    public function toUInt208(): string
    {
        return $this->convertUpTo($this->value, HexUInt208::LENGTH);
    }

    public function toUInt216(): string
    {
        return $this->convertUpTo($this->value, HexUInt216::LENGTH);
    }

    public function toUInt224(): string
    {
        return $this->convertUpTo($this->value, HexUInt224::LENGTH);
    }

    public function toUInt232(): string
    {
        return $this->convertUpTo($this->value, HexUInt232::LENGTH);
    }

    public function toUInt240(): string
    {
        return $this->convertUpTo($this->value, HexUInt240::LENGTH);
    }

    public function toUInt248(): string
    {
        return $this->convertUpTo($this->value, HexUInt248::LENGTH);
    }

    public function toUInt256(): string
    {
        return $this->convertUpTo($this->value, HexUInt256::LENGTH);
    }
}
