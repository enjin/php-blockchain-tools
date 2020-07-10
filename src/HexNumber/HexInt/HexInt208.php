<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt208 extends BaseHexInt
{
    public const HEX_LENGTH = 52;
    public const HEX_MIN = '8000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-205688069665150755269371147819668813122841983204197482918576128';
    public const INT_MAX = '205688069665150755269371147819668813122841983204197482918576127';
    public const INT_SIZE = '411376139330301510538742295639337626245683966408394965837152255';

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
