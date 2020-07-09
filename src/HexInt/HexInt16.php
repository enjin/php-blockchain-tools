<?php

namespace Enjin\BlockchainTools\HexInt;

use Enjin\BlockchainTools\HexUInt\HexUInt8;

class HexInt16 extends BaseHexInt
{
    public const LENGTH = 4;

    public const HEX_MIN = '';
    public const HEX_MAX = '';

    public const INT_MIN = '–32768';
    public const INT_MAX = '32767';

    public const SIZE = '65535';
}
