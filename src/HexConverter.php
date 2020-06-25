<?php

namespace Enjin\BlockchainTools;

use Brick\Math\BigInteger;

class HexConverter
{
    public static function prefix(string $value)
    {
        if (!self::strHasPrefix($value)) {
            $value = '0x' . $value;
        }

        return $value;
    }

    public static function unPrefix(string $value)
    {
        if (self::strHasPrefix($value)) {
            $value = substr($value, 2);
        }

        return $value;
    }

    public static function strHasPrefix(string $value) : bool
    {
        return substr($value, 0, 2) == '0x';
    }
}
