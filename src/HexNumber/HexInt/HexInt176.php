<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt176 extends BaseHexInt
{
    public const LENGTH = 44;
    public const HEX_MIN = '80000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-47890485652059026823698344598447161988085597568237568';
    public const INT_MAX = '47890485652059026823698344598447161988085597568237567';
    public const SIZE = '95780971304118053647396689196894323976171195136475135';

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