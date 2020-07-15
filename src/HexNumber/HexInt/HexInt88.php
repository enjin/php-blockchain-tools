<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt88 extends BaseHexInt
{
    public const BIT_SIZE = 88;
    public const HEX_LENGTH = 22;
    public const HEX_MIN = '8000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffff';
    public const INT_MIN = '-154742504910672534362390528';
    public const INT_MAX = '154742504910672534362390527';
    public const INT_SIZE = '309485009821345068724781055';

    public function toHexInt88(): string
    {
        return $this->value;
    }

    public function toHexInt96(): string
    {
        return $this->convertUpTo(96);
    }

    public function toHexInt104(): string
    {
        return $this->convertUpTo(104);
    }

    public function toHexInt112(): string
    {
        return $this->convertUpTo(112);
    }

    public function toHexInt120(): string
    {
        return $this->convertUpTo(120);
    }

    public function toHexInt128(): string
    {
        return $this->convertUpTo(128);
    }

    public function toHexInt136(): string
    {
        return $this->convertUpTo(136);
    }

    public function toHexInt144(): string
    {
        return $this->convertUpTo(144);
    }

    public function toHexInt152(): string
    {
        return $this->convertUpTo(152);
    }

    public function toHexInt160(): string
    {
        return $this->convertUpTo(160);
    }

    public function toHexInt168(): string
    {
        return $this->convertUpTo(168);
    }

    public function toHexInt176(): string
    {
        return $this->convertUpTo(176);
    }

    public function toHexInt184(): string
    {
        return $this->convertUpTo(184);
    }

    public function toHexInt192(): string
    {
        return $this->convertUpTo(192);
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
