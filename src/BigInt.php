<?php

namespace Enjin\BlockchainTools;

use BI\BigInteger;

class BigInt extends BigInteger
{
    public static function create($value = 0, $base = 10) : self
    {
        return new self($value, $base);
    }

    public static function uInt256($value) : self
    {
        return new self($value, 256);
    }

    public function toBigHex() : BigHex
    {
        return new BigHex($this);
    }

    public function toHexStr() : string
    {
        return parent::toHex();
    }

    public function toHexStrPrefixed() : string
    {
        return '0x' . $this->toHexStr();
    }
}
