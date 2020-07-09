<?php

namespace Enjin\BlockchainTools\HexInt;

use Enjin\BlockchainTools\HexUInt\HexUInt8;

class HexInt32 extends BaseHexInt
{
    public const LENGTH = 8;

    public const HEX_MIN = '';
    public const HEX_MAX = '';

    public const INT_MIN = '–2147483648';
    public const INT_MAX = '2147483647';

    public const SIZE = '4294967295';
}
