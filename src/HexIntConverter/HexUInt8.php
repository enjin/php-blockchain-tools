<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class HexUInt8 extends HexUInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '255';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xff';

    protected $stringLength = 2;

    public function toUInt16(): string
    {
        return $this->convertUpToUInt16($this->value);
    }

    public function toUInt32(): string
    {
        return $this->convertUpToUInt32($this->value);
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