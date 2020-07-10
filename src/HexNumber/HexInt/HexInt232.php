<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt232 extends BaseHexInt
{
    public const BIT_SIZE = 232;
    public const HEX_LENGTH = 58;
    public const HEX_MIN = '8000000000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-3450873173395281893717377931138512726225554486085193277581262111899648';
    public const INT_MAX = '3450873173395281893717377931138512726225554486085193277581262111899647';
    public const INT_SIZE = '6901746346790563787434755862277025452451108972170386555162524223799295';

    public function toHexInt232(): string
    {
        return $this->value;
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
