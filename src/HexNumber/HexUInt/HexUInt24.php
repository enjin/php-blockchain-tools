<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

class HexUInt24 extends BaseHexUInt
{
    public const HEX_LENGTH = 6;
    public const HEX_MIN = '000000';
    public const HEX_MAX = 'ffffff';
    public const INT_MIN = '0';
    public const INT_MAX = '16777215';

    public function toHexUInt8Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt8::HEX_LENGTH);
    }

    public function toHexUInt8Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt8::HEX_LENGTH);
    }

    public function toHexUInt16Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt16::HEX_LENGTH);
    }

    public function toHexUInt16Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt16::HEX_LENGTH);
    }

    public function toHexUInt32(): string
    {
        return $this->convertUpTo($this->value, HexUInt32::HEX_LENGTH);
    }

    public function toHexUInt40(): string
    {
        return $this->convertUpTo($this->value, HexUInt40::HEX_LENGTH);
    }

    public function toHexUInt48(): string
    {
        return $this->convertUpTo($this->value, HexUInt48::HEX_LENGTH);
    }

    public function toHexUInt56(): string
    {
        return $this->convertUpTo($this->value, HexUInt56::HEX_LENGTH);
    }

    public function toHexUInt64(): string
    {
        return $this->convertUpTo($this->value, HexUInt64::HEX_LENGTH);
    }

    public function toHexUInt72(): string
    {
        return $this->convertUpTo($this->value, HexUInt72::HEX_LENGTH);
    }

    public function toHexUInt80(): string
    {
        return $this->convertUpTo($this->value, HexUInt80::HEX_LENGTH);
    }

    public function toHexUInt88(): string
    {
        return $this->convertUpTo($this->value, HexUInt88::HEX_LENGTH);
    }

    public function toHexUInt96(): string
    {
        return $this->convertUpTo($this->value, HexUInt96::HEX_LENGTH);
    }

    public function toHexUInt104(): string
    {
        return $this->convertUpTo($this->value, HexUInt104::HEX_LENGTH);
    }

    public function toHexUInt112(): string
    {
        return $this->convertUpTo($this->value, HexUInt112::HEX_LENGTH);
    }

    public function toHexUInt120(): string
    {
        return $this->convertUpTo($this->value, HexUInt120::HEX_LENGTH);
    }

    public function toHexUInt128(): string
    {
        return $this->convertUpTo($this->value, HexUInt128::HEX_LENGTH);
    }

    public function toHexUInt136(): string
    {
        return $this->convertUpTo($this->value, HexUInt136::HEX_LENGTH);
    }

    public function toHexUInt144(): string
    {
        return $this->convertUpTo($this->value, HexUInt144::HEX_LENGTH);
    }

    public function toHexUInt152(): string
    {
        return $this->convertUpTo($this->value, HexUInt152::HEX_LENGTH);
    }

    public function toHexUInt160(): string
    {
        return $this->convertUpTo($this->value, HexUInt160::HEX_LENGTH);
    }

    public function toHexUInt168(): string
    {
        return $this->convertUpTo($this->value, HexUInt168::HEX_LENGTH);
    }

    public function toHexUInt176(): string
    {
        return $this->convertUpTo($this->value, HexUInt176::HEX_LENGTH);
    }

    public function toHexUInt184(): string
    {
        return $this->convertUpTo($this->value, HexUInt184::HEX_LENGTH);
    }

    public function toHexUInt192(): string
    {
        return $this->convertUpTo($this->value, HexUInt192::HEX_LENGTH);
    }

    public function toHexUInt200(): string
    {
        return $this->convertUpTo($this->value, HexUInt200::HEX_LENGTH);
    }

    public function toHexUInt208(): string
    {
        return $this->convertUpTo($this->value, HexUInt208::HEX_LENGTH);
    }

    public function toHexUInt216(): string
    {
        return $this->convertUpTo($this->value, HexUInt216::HEX_LENGTH);
    }

    public function toHexUInt224(): string
    {
        return $this->convertUpTo($this->value, HexUInt224::HEX_LENGTH);
    }

    public function toHexUInt232(): string
    {
        return $this->convertUpTo($this->value, HexUInt232::HEX_LENGTH);
    }

    public function toHexUInt240(): string
    {
        return $this->convertUpTo($this->value, HexUInt240::HEX_LENGTH);
    }

    public function toHexUInt248(): string
    {
        return $this->convertUpTo($this->value, HexUInt248::HEX_LENGTH);
    }

    public function toHexUInt256(): string
    {
        return $this->convertUpTo($this->value, HexUInt256::HEX_LENGTH);
    }
}
