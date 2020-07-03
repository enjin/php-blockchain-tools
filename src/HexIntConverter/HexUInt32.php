<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class HexUInt32 extends HexUInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '4294967295';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffff';

    protected $stringLength = 8;

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

    public function toUInt64(): string
    {
        return $this->convertUpToUInt64($this->value);
    }

    public function toUInt128(): string
    {
        return $this->convertUpToUInt128($this->value);
    }

    public function toUInt256(): string
    {
        return $this->convertUpToUInt256($this->value);
    }
}
