<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

class HexInt248 extends BaseHexInt
{
    public const BIT_SIZE = 248;
    public const HEX_LENGTH = 62;
    public const HEX_MIN = '80000000000000000000000000000000000000000000000000000000000000';
    public const HEX_MAX = '7fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff';
    public const INT_MIN = '-226156424291633194186662080095093570025917938800079226639565593765455331328';
    public const INT_MAX = '226156424291633194186662080095093570025917938800079226639565593765455331327';
    public const INT_SIZE = '452312848583266388373324160190187140051835877600158453279131187530910662655';

    public function toHexInt248(): string
    {
        return $this->value;
    }

    public function toHexInt256(): string
    {
        return $this->convertUpTo($this->value, HexInt256::HEX_LENGTH);
    }
}
