<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class UInt128 extends UInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '340282366920938463463374607431768211455';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffffffffffffffffffffffffffff';

    protected $stringLength = 32;

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

    public function toUInt256(): string
    {
        return $this->convertUpToUInt256($this->value);
    }
}
