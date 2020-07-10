<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt96 extends BaseHexInt
{
    public const BIT_SIZE = 96;
    public const HEX_LENGTH = 24;
    public const HEX_MIN = '800000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffff';
    public const INT_MIN = '-39614081257132168796771975168';
    public const INT_MAX = '39614081257132168796771975167';
    public const INT_SIZE = '79228162514264337593543950335';

    public function toHexInt96(): string
    {
        return $this->value;
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
