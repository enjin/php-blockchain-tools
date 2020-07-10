<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

class HexUInt120 extends BaseHexUInt
{
    public const BIT_SIZE = 120;
    public const HEX_LENGTH = 30;
    public const HEX_MIN = '000000000000000000000000000000';
    public const HEX_MAX = 'ffffffffffffffffffffffffffffff';
    public const INT_MIN = '0';
    public const INT_MAX = '1329227995784915872903807060280344575';

    public function toHexUInt8Top(): string
    {
        return $this->convertDownToTop(8);
    }

    public function toHexUInt8Bottom(): string
    {
        return $this->convertDownToBottom(8);
    }

    public function toHexUInt16Top(): string
    {
        return $this->convertDownToTop(16);
    }

    public function toHexUInt16Bottom(): string
    {
        return $this->convertDownToBottom(16);
    }

    public function toHexUInt24Top(): string
    {
        return $this->convertDownToTop(24);
    }

    public function toHexUInt24Bottom(): string
    {
        return $this->convertDownToBottom(24);
    }

    public function toHexUInt32Top(): string
    {
        return $this->convertDownToTop(32);
    }

    public function toHexUInt32Bottom(): string
    {
        return $this->convertDownToBottom(32);
    }

    public function toHexUInt40Top(): string
    {
        return $this->convertDownToTop(40);
    }

    public function toHexUInt40Bottom(): string
    {
        return $this->convertDownToBottom(40);
    }

    public function toHexUInt48Top(): string
    {
        return $this->convertDownToTop(48);
    }

    public function toHexUInt48Bottom(): string
    {
        return $this->convertDownToBottom(48);
    }

    public function toHexUInt56Top(): string
    {
        return $this->convertDownToTop(56);
    }

    public function toHexUInt56Bottom(): string
    {
        return $this->convertDownToBottom(56);
    }

    public function toHexUInt64Top(): string
    {
        return $this->convertDownToTop(64);
    }

    public function toHexUInt64Bottom(): string
    {
        return $this->convertDownToBottom(64);
    }

    public function toHexUInt72Top(): string
    {
        return $this->convertDownToTop(72);
    }

    public function toHexUInt72Bottom(): string
    {
        return $this->convertDownToBottom(72);
    }

    public function toHexUInt80Top(): string
    {
        return $this->convertDownToTop(80);
    }

    public function toHexUInt80Bottom(): string
    {
        return $this->convertDownToBottom(80);
    }

    public function toHexUInt88Top(): string
    {
        return $this->convertDownToTop(88);
    }

    public function toHexUInt88Bottom(): string
    {
        return $this->convertDownToBottom(88);
    }

    public function toHexUInt96Top(): string
    {
        return $this->convertDownToTop(96);
    }

    public function toHexUInt96Bottom(): string
    {
        return $this->convertDownToBottom(96);
    }

    public function toHexUInt104Top(): string
    {
        return $this->convertDownToTop(104);
    }

    public function toHexUInt104Bottom(): string
    {
        return $this->convertDownToBottom(104);
    }

    public function toHexUInt112Top(): string
    {
        return $this->convertDownToTop(112);
    }

    public function toHexUInt112Bottom(): string
    {
        return $this->convertDownToBottom(112);
    }

    public function toHexUInt120(): string
    {
        return $this->value;
    }

    public function toHexUInt128(): string
    {
        return $this->convertUpTo(128);
    }

    public function toHexUInt136(): string
    {
        return $this->convertUpTo(136);
    }

    public function toHexUInt144(): string
    {
        return $this->convertUpTo(144);
    }

    public function toHexUInt152(): string
    {
        return $this->convertUpTo(152);
    }

    public function toHexUInt160(): string
    {
        return $this->convertUpTo(160);
    }

    public function toHexUInt168(): string
    {
        return $this->convertUpTo(168);
    }

    public function toHexUInt176(): string
    {
        return $this->convertUpTo(176);
    }

    public function toHexUInt184(): string
    {
        return $this->convertUpTo(184);
    }

    public function toHexUInt192(): string
    {
        return $this->convertUpTo(192);
    }

    public function toHexUInt200(): string
    {
        return $this->convertUpTo(200);
    }

    public function toHexUInt208(): string
    {
        return $this->convertUpTo(208);
    }

    public function toHexUInt216(): string
    {
        return $this->convertUpTo(216);
    }

    public function toHexUInt224(): string
    {
        return $this->convertUpTo(224);
    }

    public function toHexUInt232(): string
    {
        return $this->convertUpTo(232);
    }

    public function toHexUInt240(): string
    {
        return $this->convertUpTo(240);
    }

    public function toHexUInt248(): string
    {
        return $this->convertUpTo(248);
    }

    public function toHexUInt256(): string
    {
        return $this->convertUpTo(256);
    }
}
