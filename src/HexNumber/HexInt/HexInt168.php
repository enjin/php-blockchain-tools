<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt168 extends BaseHexInt
{
    public const BIT_SIZE = 168;
    public const HEX_LENGTH = 42;
    public const HEX_MIN = '800000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-187072209578355573530071658587684226515959365500928';
    public const INT_MAX = '187072209578355573530071658587684226515959365500927';
    public const INT_SIZE = '374144419156711147060143317175368453031918731001855';

    public function toHexInt168(): string
    {
        return $this->value;
    }

    public function toHexInt176(): string
    {
        return $this->convertUpTo(176);
    }

    public function toHexInt184(): string
    {
        return $this->convertUpTo(184);
    }

    public function toHexInt192(): string
    {
        return $this->convertUpTo(192);
    }

    public function toHexInt200(): string
    {
        return $this->convertUpTo(200);
    }

    public function toHexInt208(): string
    {
        return $this->convertUpTo(208);
    }

    public function toHexInt216(): string
    {
        return $this->convertUpTo(216);
    }

    public function toHexInt224(): string
    {
        return $this->convertUpTo(224);
    }

    public function toHexInt232(): string
    {
        return $this->convertUpTo(232);
    }

    public function toHexInt240(): string
    {
        return $this->convertUpTo(240);
    }

    public function toHexInt248(): string
    {
        return $this->convertUpTo(248);
    }

    public function toHexInt256(): string
    {
        return $this->convertUpTo(256);
    }
}
