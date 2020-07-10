<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt120 extends BaseHexInt
{
    public const HEX_LENGTH = 30;
    public const HEX_MIN = '800000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffff';
    public const INT_MIN = '-664613997892457936451903530140172288';
    public const INT_MAX = '664613997892457936451903530140172287';
    public const INT_SIZE = '1329227995784915872903807060280344575';

    public function toHexInt128(): string
    {
        return $this->convertUpTo($this->value, HexInt128::HEX_LENGTH);
    }

    public function toHexInt136(): string
    {
        return $this->convertUpTo($this->value, HexInt136::HEX_LENGTH);
    }

    public function toHexInt144(): string
    {
        return $this->convertUpTo($this->value, HexInt144::HEX_LENGTH);
    }

    public function toHexInt152(): string
    {
        return $this->convertUpTo($this->value, HexInt152::HEX_LENGTH);
    }

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
