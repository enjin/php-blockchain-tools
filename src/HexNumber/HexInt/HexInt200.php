<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt200 extends HexInt
{
    public const HEX_LENGTH = 50;
    public const HEX_MIN = '80000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-803469022129495137770981046170581301261101496891396417650688';
    public const INT_MAX = '803469022129495137770981046170581301261101496891396417650687';
    public const INT_SIZE = '1606938044258990275541962092341162602522202993782792835301375';

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
