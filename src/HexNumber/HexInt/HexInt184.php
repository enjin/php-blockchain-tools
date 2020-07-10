<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt184 extends BaseHexInt
{
    public const BIT_SIZE = 184;
    public const HEX_LENGTH = 46;
    public const HEX_MIN = '8000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-12259964326927110866866776217202473468949912977468817408';
    public const INT_MAX = '12259964326927110866866776217202473468949912977468817407';
    public const INT_SIZE = '24519928653854221733733552434404946937899825954937634815';

    public function toHexInt184(): string
    {
        return $this->value;
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
