<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class UInt16 extends UInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '65535';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffff';

    protected $stringLength = 4;

    public function toUInt8Top()
    {
        return $this->covertDownToUInt8Top($this->value);
    }

    public function toUInt8Bottom()
    {
        return $this->covertDownToUInt8Bottom($this->value);
    }

    public function toUInt32()
    {
        return $this->convertUpToUInt32($this->value);
    }

    public function toUInt64()
    {
        return $this->convertUpToUInt64($this->value);
    }

    public function toUInt128()
    {
        return $this->convertUpToUInt128($this->value);
    }

    public function toUInt256()
    {
        return $this->convertUpToUInt256($this->value);
    }
}