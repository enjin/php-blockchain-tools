<?php

namespace Enjin\BlockchainTools\HexIntConverter;

class UInt64 extends UInt
{
    public const MIN_VALUE = '0';
    public const MAX_VALUE = '18446744073709551615';

    public const MIN_ENCODED_VALUE = '0x0';
    public const MAX_ENCODED_VALUE = '0xffffffffffffffff';

    protected $stringLength = 16;

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

    public function toUInt128()
    {
        return $this->convertUpToUInt128($this->value);
    }

    public function toUInt256()
    {
        return $this->convertUpToUInt256($this->value);
    }
}
