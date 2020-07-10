<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt152 extends BaseHexInt
{
    public const BIT_SIZE = 152;
    public const HEX_LENGTH = 38;
    public const HEX_MIN = '80000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-2854495385411919762116571938898990272765493248';
    public const INT_MAX = '2854495385411919762116571938898990272765493247';
    public const INT_SIZE = '5708990770823839524233143877797980545530986495';

    public function toHexInt152(): string
    {
        return $this->value;
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
