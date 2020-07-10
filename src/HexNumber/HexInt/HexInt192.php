<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt192 extends BaseHexInt
{
    public const BIT_SIZE = 192;
    public const HEX_LENGTH = 48;
    public const HEX_MIN = '800000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-3138550867693340381917894711603833208051177722232017256448';
    public const INT_MAX = '3138550867693340381917894711603833208051177722232017256447';
    public const INT_SIZE = '6277101735386680763835789423207666416102355444464034512895';

    public function toHexInt192(): string
    {
        return $this->value;
    }

    public function toHexInt200(): string
    {
        return $this->convertUpTo(200);
    }

    public function toHexInt208(): string
    {
        return $this->convertUpTo(208);
    }

    public function toHexInt216(): string
    {
        return $this->convertUpTo(216);
    }

    public function toHexInt224(): string
    {
        return $this->convertUpTo(224);
    }

    public function toHexInt232(): string
    {
        return $this->convertUpTo(232);
    }

    public function toHexInt240(): string
    {
        return $this->convertUpTo(240);
    }

    public function toHexInt248(): string
    {
        return $this->convertUpTo(248);
    }

    public function toHexInt256(): string
    {
        return $this->convertUpTo(256);
    }
}
