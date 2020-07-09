<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

class HexUInt224 extends BaseHexUInt
{
    public const HEX_LENGTH = 56;
    public const HEX_MIN = '00000000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '0';
    public const INT_MAX = '26959946667150639794667015087019630673637144422540572481103610249215';

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

    public function toHexUInt24Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt24::HEX_LENGTH);
    }

    public function toHexUInt24Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt24::HEX_LENGTH);
    }

    public function toHexUInt32Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt32::HEX_LENGTH);
    }

    public function toHexUInt32Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt32::HEX_LENGTH);
    }

    public function toHexUInt40Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt40::HEX_LENGTH);
    }

    public function toHexUInt40Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt40::HEX_LENGTH);
    }

    public function toHexUInt48Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt48::HEX_LENGTH);
    }

    public function toHexUInt48Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt48::HEX_LENGTH);
    }

    public function toHexUInt56Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt56::HEX_LENGTH);
    }

    public function toHexUInt56Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt56::HEX_LENGTH);
    }

    public function toHexUInt64Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt64::HEX_LENGTH);
    }

    public function toHexUInt64Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt64::HEX_LENGTH);
    }

    public function toHexUInt72Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt72::HEX_LENGTH);
    }

    public function toHexUInt72Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt72::HEX_LENGTH);
    }

    public function toHexUInt80Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt80::HEX_LENGTH);
    }

    public function toHexUInt80Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt80::HEX_LENGTH);
    }

    public function toHexUInt88Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt88::HEX_LENGTH);
    }

    public function toHexUInt88Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt88::HEX_LENGTH);
    }

    public function toHexUInt96Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt96::HEX_LENGTH);
    }

    public function toHexUInt96Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt96::HEX_LENGTH);
    }

    public function toHexUInt104Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt104::HEX_LENGTH);
    }

    public function toHexUInt104Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt104::HEX_LENGTH);
    }

    public function toHexUInt112Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt112::HEX_LENGTH);
    }

    public function toHexUInt112Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt112::HEX_LENGTH);
    }

    public function toHexUInt120Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt120::HEX_LENGTH);
    }

    public function toHexUInt120Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt120::HEX_LENGTH);
    }

    public function toHexUInt128Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt128::HEX_LENGTH);
    }

    public function toHexUInt128Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt128::HEX_LENGTH);
    }

    public function toHexUInt136Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt136::HEX_LENGTH);
    }

    public function toHexUInt136Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt136::HEX_LENGTH);
    }

    public function toHexUInt144Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt144::HEX_LENGTH);
    }

    public function toHexUInt144Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt144::HEX_LENGTH);
    }

    public function toHexUInt152Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt152::HEX_LENGTH);
    }

    public function toHexUInt152Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt152::HEX_LENGTH);
    }

    public function toHexUInt160Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt160::HEX_LENGTH);
    }

    public function toHexUInt160Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt160::HEX_LENGTH);
    }

    public function toHexUInt168Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt168::HEX_LENGTH);
    }

    public function toHexUInt168Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt168::HEX_LENGTH);
    }

    public function toHexUInt176Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt176::HEX_LENGTH);
    }

    public function toHexUInt176Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt176::HEX_LENGTH);
    }

    public function toHexUInt184Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt184::HEX_LENGTH);
    }

    public function toHexUInt184Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt184::HEX_LENGTH);
    }

    public function toHexUInt192Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt192::HEX_LENGTH);
    }

    public function toHexUInt192Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt192::HEX_LENGTH);
    }

    public function toHexUInt200Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt200::HEX_LENGTH);
    }

    public function toHexUInt200Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt200::HEX_LENGTH);
    }

    public function toHexUInt208Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt208::HEX_LENGTH);
    }

    public function toHexUInt208Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt208::HEX_LENGTH);
    }

    public function toHexUInt216Top(): string
    {
        return $this->convertDownToTop($this->value, HexUInt216::HEX_LENGTH);
    }

    public function toHexUInt216Bottom(): string
    {
        return $this->convertDownToBottom($this->value, HexUInt216::HEX_LENGTH);
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
