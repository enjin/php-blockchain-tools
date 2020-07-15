<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt208 extends BaseHexInt
{
    public const BIT_SIZE = 208;
    public const HEX_LENGTH = 52;
    public const HEX_MIN = '8000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-205688069665150755269371147819668813122841983204197482918576128';
    public const INT_MAX = '205688069665150755269371147819668813122841983204197482918576127';
    public const INT_SIZE = '411376139330301510538742295639337626245683966408394965837152255';

    public function toHexInt208(): string
    {
        return $this->value;
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
