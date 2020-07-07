<?php

namespace Enjin\BlockchainTools\HexUInt;

class HexUInt128 extends BaseHexUInt
{
    public const LENGTH = 32;
    public const HEX_MIN = '00000000000000000000000000000000';
    public const HEX_MAX = 'ffffffffffffffffffffffffffffffff';
    public const INT_MIN = '0';
    public const INT_MAX = '340282366920938463463374607431768211455';

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

    public function toUInt40Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt40::LENGTH);
    }

    public function toUInt40Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt40::LENGTH);
    }

    public function toUInt48Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt48::LENGTH);
    }

    public function toUInt48Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt48::LENGTH);
    }

    public function toUInt56Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt56::LENGTH);
    }

    public function toUInt56Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt56::LENGTH);
    }

    public function toUInt64Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt64::LENGTH);
    }

    public function toUInt64Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt64::LENGTH);
    }

    public function toUInt72Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt72::LENGTH);
    }

    public function toUInt72Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt72::LENGTH);
    }

    public function toUInt80Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt80::LENGTH);
    }

    public function toUInt80Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt80::LENGTH);
    }

    public function toUInt88Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt88::LENGTH);
    }

    public function toUInt88Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt88::LENGTH);
    }

    public function toUInt96Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt96::LENGTH);
    }

    public function toUInt96Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt96::LENGTH);
    }

    public function toUInt104Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt104::LENGTH);
    }

    public function toUInt104Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt104::LENGTH);
    }

    public function toUInt112Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt112::LENGTH);
    }

    public function toUInt112Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt112::LENGTH);
    }

    public function toUInt120Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt120::LENGTH);
    }

    public function toUInt120Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt120::LENGTH);
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
