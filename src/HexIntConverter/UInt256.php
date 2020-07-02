<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class UInt256 extends UInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '115792089237316195423570985008687907853269984665640564039457584007913129639935';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';

    protected $stringLength = 64;

    public function toUInt8Top()
    {
        return $this->covertDownToUInt8Top($this->value);
    }

    public function toUInt8Bottom()
    {
        return $this->covertDownToUInt8Bottom($this->value);
    }

    public function toUInt16Top()
    {
        return $this->covertDownToUInt16Top($this->value);
    }

    public function toUInt16Bottom()
    {
        return $this->covertDownToUInt16Bottom($this->value);
    }

    public function toUInt32Top()
    {
        return $this->covertDownToUInt32Top($this->value);
    }

    public function toUInt32Bottom()
    {
        return $this->covertDownToUInt32Bottom($this->value);
    }

    public function toUInt64Top()
    {
        return $this->covertDownToUInt64Top($this->value);
    }

    public function toUInt64Bottom()
    {
        return $this->covertDownToUInt64Bottom($this->value);
    }

    public function toUInt128Top()
    {
        return $this->covertDownToUInt128Top($this->value);
    }

    public function toUInt128Bottom()
    {
        return $this->covertDownToUInt128Bottom($this->value);
    }
}
