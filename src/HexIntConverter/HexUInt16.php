<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class HexUInt16 extends HexUInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '65535';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffff';

    protected $stringLength = 4;

    public function toUInt8Top(): string
    {
        return $this->covertDownToUInt8Top($this->value);
    }

    public function toUInt8Bottom(): string
    {
        return $this->covertDownToUInt8Bottom($this->value);
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
