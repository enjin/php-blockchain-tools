<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

class HexUInt40 extends BaseHexUInt
{
    public const LENGTH = 10;
    public const HEX_MIN = '0000000000';
    public const HEX_MAX = 'ffffffffff';
    public const INT_MIN = '0';
    public const INT_MAX = '1099511627775';

    public function toHexUInt8Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt8::LENGTH);
    }

    public function toHexUInt8Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt8::LENGTH);
    }

    public function toHexUInt16Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt16::LENGTH);
    }

    public function toHexUInt16Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt16::LENGTH);
    }

    public function toHexUInt24Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt24::LENGTH);
    }

    public function toHexUInt24Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt24::LENGTH);
    }

    public function toHexUInt32Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt32::LENGTH);
    }

    public function toHexUInt32Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt32::LENGTH);
    }

    public function toHexUInt48(): string
    {
        return $this->convertUpTo($this->value, HexUInt48::LENGTH);
    }

    public function toHexUInt56(): string
    {
        return $this->convertUpTo($this->value, HexUInt56::LENGTH);
    }

    public function toHexUInt64(): string
    {
        return $this->convertUpTo($this->value, HexUInt64::LENGTH);
    }

    public function toHexUInt72(): string
    {
        return $this->convertUpTo($this->value, HexUInt72::LENGTH);
    }

    public function toHexUInt80(): string
    {
        return $this->convertUpTo($this->value, HexUInt80::LENGTH);
    }

    public function toHexUInt88(): string
    {
        return $this->convertUpTo($this->value, HexUInt88::LENGTH);
    }

    public function toHexUInt96(): string
    {
        return $this->convertUpTo($this->value, HexUInt96::LENGTH);
    }

    public function toHexUInt104(): string
    {
        return $this->convertUpTo($this->value, HexUInt104::LENGTH);
    }

    public function toHexUInt112(): string
    {
        return $this->convertUpTo($this->value, HexUInt112::LENGTH);
    }

    public function toHexUInt120(): string
    {
        return $this->convertUpTo($this->value, HexUInt120::LENGTH);
    }

    public function toHexUInt128(): string
    {
        return $this->convertUpTo($this->value, HexUInt128::LENGTH);
    }

    public function toHexUInt136(): string
    {
        return $this->convertUpTo($this->value, HexUInt136::LENGTH);
    }

    public function toHexUInt144(): string
    {
        return $this->convertUpTo($this->value, HexUInt144::LENGTH);
    }

    public function toHexUInt152(): string
    {
        return $this->convertUpTo($this->value, HexUInt152::LENGTH);
    }

    public function toHexUInt160(): string
    {
        return $this->convertUpTo($this->value, HexUInt160::LENGTH);
    }

    public function toHexUInt168(): string
    {
        return $this->convertUpTo($this->value, HexUInt168::LENGTH);
    }

    public function toHexUInt176(): string
    {
        return $this->convertUpTo($this->value, HexUInt176::LENGTH);
    }

    public function toHexUInt184(): string
    {
        return $this->convertUpTo($this->value, HexUInt184::LENGTH);
    }

    public function toHexUInt192(): string
    {
        return $this->convertUpTo($this->value, HexUInt192::LENGTH);
    }

    public function toHexUInt200(): string
    {
        return $this->convertUpTo($this->value, HexUInt200::LENGTH);
    }

    public function toHexUInt208(): string
    {
        return $this->convertUpTo($this->value, HexUInt208::LENGTH);
    }

    public function toHexUInt216(): string
    {
        return $this->convertUpTo($this->value, HexUInt216::LENGTH);
    }

    public function toHexUInt224(): string
    {
        return $this->convertUpTo($this->value, HexUInt224::LENGTH);
    }

    public function toHexUInt232(): string
    {
        return $this->convertUpTo($this->value, HexUInt232::LENGTH);
    }

    public function toHexUInt240(): string
    {
        return $this->convertUpTo($this->value, HexUInt240::LENGTH);
    }

    public function toHexUInt248(): string
    {
        return $this->convertUpTo($this->value, HexUInt248::LENGTH);
    }

    public function toHexUInt256(): string
    {
        return $this->convertUpTo($this->value, HexUInt256::LENGTH);
    }
}
