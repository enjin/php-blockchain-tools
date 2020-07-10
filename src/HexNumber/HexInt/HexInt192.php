<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt192 extends HexInt
{
    public const HEX_LENGTH = 48;
    public const HEX_MIN = '800000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-3138550867693340381917894711603833208051177722232017256448';
    public const INT_MAX = '3138550867693340381917894711603833208051177722232017256447';
    public const INT_SIZE = '6277101735386680763835789423207666416102355444464034512895';

    public function toHexInt200(): string
    {
        return $this->convertUpTo($this->value, HexInt200::HEX_LENGTH);
    }

    public function toHexInt208(): string
    {
        return $this->convertUpTo($this->value, HexInt208::HEX_LENGTH);
    }

    public function toHexInt216(): string
    {
        return $this->convertUpTo($this->value, HexInt216::HEX_LENGTH);
    }

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
