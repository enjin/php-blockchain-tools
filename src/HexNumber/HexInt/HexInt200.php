<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt200 extends BaseHexInt
{
    public const LENGTH = 50;
    public const HEX_MIN = '80000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-803469022129495137770981046170581301261101496891396417650688';
    public const INT_MAX = '803469022129495137770981046170581301261101496891396417650687';
    public const SIZE = '1606938044258990275541962092341162602522202993782792835301375';

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
