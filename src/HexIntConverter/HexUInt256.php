<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class HexUInt256 extends HexUInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '115792089237316195423570985008687907853269984665640564039457584007913129639935';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';

    protected $stringLength = 64;

    public function toUInt8Top(): string
    {
        return $this->covertDownToUInt8Top($this->value);
    }

    public function toUInt8Bottom(): string
    {
        return $this->covertDownToUInt8Bottom($this->value);
    }

    public function toUInt16Top(): string
    {
        return $this->covertDownToUInt16Top($this->value);
    }

    public function toUInt16Bottom(): string
    {
        return $this->covertDownToUInt16Bottom($this->value);
    }

    public function toUInt32Top(): string
    {
        return $this->covertDownToUInt32Top($this->value);
    }

    public function toUInt32Bottom(): string
    {
        return $this->covertDownToUInt32Bottom($this->value);
    }

    public function toUInt64Top(): string
    {
        return $this->covertDownToUInt64Top($this->value);
    }

    public function toUInt64Bottom(): string
    {
        return $this->covertDownToUInt64Bottom($this->value);
    }

    public function toUInt128Top(): string
    {
        return $this->covertDownToUInt128Top($this->value);
    }

    public function toUInt128Bottom(): string
    {
        return $this->covertDownToUInt128Bottom($this->value);
    }
}
