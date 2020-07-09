<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt136 extends BaseHexInt
{
    public const LENGTH = 34;
    public const HEX_MIN = '8000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-43556142965880123323311949751266331066368';
    public const INT_MAX = '43556142965880123323311949751266331066367';
    public const SIZE = '87112285931760246646623899502532662132735';

    public function toHexInt144(): string
    {
        return $this->convertUpTo($this->value, HexInt144::LENGTH);
    }

    public function toHexInt152(): string
    {
        return $this->convertUpTo($this->value, HexInt152::LENGTH);
    }

    public function toHexInt160(): string
    {
        return $this->convertUpTo($this->value, HexInt160::LENGTH);
    }

    public function toHexInt168(): string
    {
        return $this->convertUpTo($this->value, HexInt168::LENGTH);
    }

    public function toHexInt176(): string
    {
        return $this->convertUpTo($this->value, HexInt176::LENGTH);
    }

    public function toHexInt184(): string
    {
        return $this->convertUpTo($this->value, HexInt184::LENGTH);
    }

    public function toHexInt192(): string
    {
        return $this->convertUpTo($this->value, HexInt192::LENGTH);
    }

    public function toHexInt200(): string
    {
        return $this->convertUpTo($this->value, HexInt200::LENGTH);
    }

    public function toHexInt208(): string
    {
        return $this->convertUpTo($this->value, HexInt208::LENGTH);
    }

    public function toHexInt216(): string
    {
        return $this->convertUpTo($this->value, HexInt216::LENGTH);
    }

    public function toHexInt224(): string
    {
        return $this->convertUpTo($this->value, HexInt224::LENGTH);
    }

    public function toHexInt232(): string
    {
        return $this->convertUpTo($this->value, HexInt232::LENGTH);
    }

    public function toHexInt240(): string
    {
        return $this->convertUpTo($this->value, HexInt240::LENGTH);
    }

    public function toHexInt248(): string
    {
        return $this->convertUpTo($this->value, HexInt248::LENGTH);
    }

    public function toHexInt256(): string
    {
        return $this->convertUpTo($this->value, HexInt256::LENGTH);
    }
}
