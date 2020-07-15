<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt160 extends BaseHexInt
{
    public const BIT_SIZE = 160;
    public const HEX_LENGTH = 40;
    public const HEX_MIN = '8000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-730750818665451459101842416358141509827966271488';
    public const INT_MAX = '730750818665451459101842416358141509827966271487';
    public const INT_SIZE = '1461501637330902918203684832716283019655932542975';

    public function toHexInt160(): string
    {
        return $this->value;
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
