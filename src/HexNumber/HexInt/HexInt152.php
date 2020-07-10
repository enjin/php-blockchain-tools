<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt152 extends HexInt
{
    public const HEX_LENGTH = 38;
    public const HEX_MIN = '80000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-2854495385411919762116571938898990272765493248';
    public const INT_MAX = '2854495385411919762116571938898990272765493247';
    public const INT_SIZE = '5708990770823839524233143877797980545530986495';

    public function toHexInt160(): string
    {
        return $this->convertUpTo($this->value, HexInt160::HEX_LENGTH);
    }

    public function toHexInt168(): string
    {
        return $this->convertUpTo($this->value, HexInt168::HEX_LENGTH);
    }

    public function toHexInt176(): string
    {
        return $this->convertUpTo($this->value, HexInt176::HEX_LENGTH);
    }

    public function toHexInt184(): string
    {
        return $this->convertUpTo($this->value, HexInt184::HEX_LENGTH);
    }

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
