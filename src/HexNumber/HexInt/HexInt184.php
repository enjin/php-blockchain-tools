<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt184 extends BaseHexInt
{
    public const HEX_LENGTH = 46;
    public const HEX_MIN = '8000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-12259964326927110866866776217202473468949912977468817408';
    public const INT_MAX = '12259964326927110866866776217202473468949912977468817407';
    public const INT_SIZE = '24519928653854221733733552434404946937899825954937634815';

    public function toHexInt192(): string
    {
        return $this->convertUpTo($this->value, HexInt192::HEX_LENGTH);
    }

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
