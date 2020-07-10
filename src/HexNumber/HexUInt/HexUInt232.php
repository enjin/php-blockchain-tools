<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

class HexUInt232 extends BaseHexUInt
{
    public const BIT_SIZE = 232;
    public const HEX_LENGTH = 58;
    public const HEX_MIN = '0000000000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = 'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '0';
    public const INT_MAX = '6901746346790563787434755862277025452451108972170386555162524223799295';

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

    public function toHexUInt120Top(): string
    {
        return $this->convertDownToTop(120);
    }

    public function toHexUInt120Bottom(): string
    {
        return $this->convertDownToBottom(120);
    }

    public function toHexUInt128Top(): string
    {
        return $this->convertDownToTop(128);
    }

    public function toHexUInt128Bottom(): string
    {
        return $this->convertDownToBottom(128);
    }

    public function toHexUInt136Top(): string
    {
        return $this->convertDownToTop(136);
    }

    public function toHexUInt136Bottom(): string
    {
        return $this->convertDownToBottom(136);
    }

    public function toHexUInt144Top(): string
    {
        return $this->convertDownToTop(144);
    }

    public function toHexUInt144Bottom(): string
    {
        return $this->convertDownToBottom(144);
    }

    public function toHexUInt152Top(): string
    {
        return $this->convertDownToTop(152);
    }

    public function toHexUInt152Bottom(): string
    {
        return $this->convertDownToBottom(152);
    }

    public function toHexUInt160Top(): string
    {
        return $this->convertDownToTop(160);
    }

    public function toHexUInt160Bottom(): string
    {
        return $this->convertDownToBottom(160);
    }

    public function toHexUInt168Top(): string
    {
        return $this->convertDownToTop(168);
    }

    public function toHexUInt168Bottom(): string
    {
        return $this->convertDownToBottom(168);
    }

    public function toHexUInt176Top(): string
    {
        return $this->convertDownToTop(176);
    }

    public function toHexUInt176Bottom(): string
    {
        return $this->convertDownToBottom(176);
    }

    public function toHexUInt184Top(): string
    {
        return $this->convertDownToTop(184);
    }

    public function toHexUInt184Bottom(): string
    {
        return $this->convertDownToBottom(184);
    }

    public function toHexUInt192Top(): string
    {
        return $this->convertDownToTop(192);
    }

    public function toHexUInt192Bottom(): string
    {
        return $this->convertDownToBottom(192);
    }

    public function toHexUInt200Top(): string
    {
        return $this->convertDownToTop(200);
    }

    public function toHexUInt200Bottom(): string
    {
        return $this->convertDownToBottom(200);
    }

    public function toHexUInt208Top(): string
    {
        return $this->convertDownToTop(208);
    }

    public function toHexUInt208Bottom(): string
    {
        return $this->convertDownToBottom(208);
    }

    public function toHexUInt216Top(): string
    {
        return $this->convertDownToTop(216);
    }

    public function toHexUInt216Bottom(): string
    {
        return $this->convertDownToBottom(216);
    }

    public function toHexUInt224Top(): string
    {
        return $this->convertDownToTop(224);
    }

    public function toHexUInt224Bottom(): string
    {
        return $this->convertDownToBottom(224);
    }

    public function toHexUInt232(): string
    {
        return $this->value;
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
