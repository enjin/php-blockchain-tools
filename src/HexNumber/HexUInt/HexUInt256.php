<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

class HexUInt256 extends BaseHexUInt
{
    public const LENGTH = 64;
    public const HEX_MIN = '0000000000000000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '0';
    public const INT_MAX = '115792089237316195423570985008687907853269984665640564039457584007913129639935';

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

    public function toHexUInt40Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt40::LENGTH);
    }

    public function toHexUInt40Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt40::LENGTH);
    }

    public function toHexUInt48Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt48::LENGTH);
    }

    public function toHexUInt48Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt48::LENGTH);
    }

    public function toHexUInt56Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt56::LENGTH);
    }

    public function toHexUInt56Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt56::LENGTH);
    }

    public function toHexUInt64Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt64::LENGTH);
    }

    public function toHexUInt64Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt64::LENGTH);
    }

    public function toHexUInt72Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt72::LENGTH);
    }

    public function toHexUInt72Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt72::LENGTH);
    }

    public function toHexUInt80Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt80::LENGTH);
    }

    public function toHexUInt80Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt80::LENGTH);
    }

    public function toHexUInt88Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt88::LENGTH);
    }

    public function toHexUInt88Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt88::LENGTH);
    }

    public function toHexUInt96Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt96::LENGTH);
    }

    public function toHexUInt96Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt96::LENGTH);
    }

    public function toHexUInt104Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt104::LENGTH);
    }

    public function toHexUInt104Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt104::LENGTH);
    }

    public function toHexUInt112Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt112::LENGTH);
    }

    public function toHexUInt112Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt112::LENGTH);
    }

    public function toHexUInt120Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt120::LENGTH);
    }

    public function toHexUInt120Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt120::LENGTH);
    }

    public function toHexUInt128Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt128::LENGTH);
    }

    public function toHexUInt128Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt128::LENGTH);
    }

    public function toHexUInt136Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt136::LENGTH);
    }

    public function toHexUInt136Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt136::LENGTH);
    }

    public function toHexUInt144Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt144::LENGTH);
    }

    public function toHexUInt144Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt144::LENGTH);
    }

    public function toHexUInt152Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt152::LENGTH);
    }

    public function toHexUInt152Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt152::LENGTH);
    }

    public function toHexUInt160Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt160::LENGTH);
    }

    public function toHexUInt160Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt160::LENGTH);
    }

    public function toHexUInt168Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt168::LENGTH);
    }

    public function toHexUInt168Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt168::LENGTH);
    }

    public function toHexUInt176Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt176::LENGTH);
    }

    public function toHexUInt176Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt176::LENGTH);
    }

    public function toHexUInt184Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt184::LENGTH);
    }

    public function toHexUInt184Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt184::LENGTH);
    }

    public function toHexUInt192Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt192::LENGTH);
    }

    public function toHexUInt192Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt192::LENGTH);
    }

    public function toHexUInt200Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt200::LENGTH);
    }

    public function toHexUInt200Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt200::LENGTH);
    }

    public function toHexUInt208Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt208::LENGTH);
    }

    public function toHexUInt208Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt208::LENGTH);
    }

    public function toHexUInt216Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt216::LENGTH);
    }

    public function toHexUInt216Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt216::LENGTH);
    }

    public function toHexUInt224Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt224::LENGTH);
    }

    public function toHexUInt224Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt224::LENGTH);
    }

    public function toHexUInt232Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt232::LENGTH);
    }

    public function toHexUInt232Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt232::LENGTH);
    }

    public function toHexUInt240Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt240::LENGTH);
    }

    public function toHexUInt240Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt240::LENGTH);
    }

    public function toHexUInt248Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt248::LENGTH);
    }

    public function toHexUInt248Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt248::LENGTH);
    }
}