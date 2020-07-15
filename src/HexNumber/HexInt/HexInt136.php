<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt136 extends BaseHexInt
{
    public const BIT_SIZE = 136;
    public const HEX_LENGTH = 34;
    public const HEX_MIN = '8000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-43556142965880123323311949751266331066368';
    public const INT_MAX = '43556142965880123323311949751266331066367';
    public const INT_SIZE = '87112285931760246646623899502532662132735';

    public function toHexInt136(): string
    {
        return $this->value;
    }

    public function toHexInt144(): string
    {
        return $this->convertUpTo(144);
    }

    public function toHexInt152(): string
    {
        return $this->convertUpTo(152);
    }

    public function toHexInt160(): string
    {
        return $this->convertUpTo(160);
    }

    public function toHexInt168(): string
    {
        return $this->convertUpTo(168);
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
