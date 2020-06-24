<?php

namespace Enjin\BlockchainTools;

class HexConverter
{
    static public function prefix(string $value)
    {
        if (!self::strHasPrefix($value)) {
            $value = '0x' . $value;
        }

        return $value;
    }

    static public function unPrefix(string $value)
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
