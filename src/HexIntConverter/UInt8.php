<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class UInt8 extends UInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '255';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xff';

    protected $stringLength = 2;

    public function toUInt16()
    {
        return $this->convertUpToUInt16($this->value);
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
