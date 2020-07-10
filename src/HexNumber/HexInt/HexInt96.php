<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt96 extends HexInt
{
    public const HEX_LENGTH = 24;
    public const HEX_MIN = '800000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffff';
    public const INT_MIN = '-39614081257132168796771975168';
    public const INT_MAX = '39614081257132168796771975167';
    public const INT_SIZE = '79228162514264337593543950335';

    public function toHexInt104(): string
    {
        return $this->convertUpTo($this->value, HexInt104::HEX_LENGTH);
    }

    public function toHexInt112(): string
    {
        return $this->convertUpTo($this->value, HexInt112::HEX_LENGTH);
    }

    public function toHexInt120(): string
    {
        return $this->convertUpTo($this->value, HexInt120::HEX_LENGTH);
    }

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
