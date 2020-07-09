<?php

namespace Enjin\BlockchainTools\HexInt;

use Enjin\BlockchainTools\HexUInt\HexUInt8;

class HexInt8 extends BaseHexInt
{
    public const LENGTH = 2;

    public const HEX_MIN = '80';
    public const HEX_MAX = '7f';

    public const INT_MIN = '-128';
    public const INT_MAX = '127';

    public const SIZE = '256';
}
