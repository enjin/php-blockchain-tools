<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt200 extends BaseHexInt
{
    public const BIT_SIZE = 200;
    public const HEX_LENGTH = 50;
    public const HEX_MIN = '80000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-803469022129495137770981046170581301261101496891396417650688';
    public const INT_MAX = '803469022129495137770981046170581301261101496891396417650687';
    public const INT_SIZE = '1606938044258990275541962092341162602522202993782792835301375';

    public function toHexInt200(): string
    {
        return $this->value;
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
