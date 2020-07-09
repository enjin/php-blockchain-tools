<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt208 extends BaseHexInt
{
    public const LENGTH = 52;
    public const HEX_MIN = '8000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-205688069665150755269371147819668813122841983204197482918576128';
    public const INT_MAX = '205688069665150755269371147819668813122841983204197482918576127';
    public const SIZE = '411376139330301510538742295639337626245683966408394965837152255';

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
