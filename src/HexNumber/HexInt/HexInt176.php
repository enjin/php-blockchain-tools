<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt176 extends BaseHexInt
{
    public const BIT_SIZE = 176;
    public const HEX_LENGTH = 44;
    public const HEX_MIN = '80000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-47890485652059026823698344598447161988085597568237568';
    public const INT_MAX = '47890485652059026823698344598447161988085597568237567';
    public const INT_SIZE = '95780971304118053647396689196894323976171195136475135';

    public function toHexInt176(): string
    {
        return $this->value;
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
