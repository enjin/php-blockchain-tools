<?php

namespace Enjin\BlockchainTools;

class HexConverter
{
    public static function prefix(string $value): string
    {
        if (!self::strHasPrefix($value)) {
            $value = '0x' . $value;
        }

        return $value;
    }

    public static function unPrefix(string $value): string
    {
        if (self::strHasPrefix($value)) {
            $value = substr($value, 2);
        }

        return $value;
    }

    public static function strHasPrefix(string $value): bool
    {
        return substr($value, 0, 2) == '0x';
    }

    public static function encodeString(string $string, int $length = null): string
    {
        $hex = implode('', unpack('H*', $string));

        $padLength = 0;

        if ($length) {
            $padLength = strlen($hex) + $length - strlen($hex) % $length;
        }

        return str_pad($hex, $padLength, '0');
    }

    public static function encodeStringPrefixed(string $string, int $length = null): string
    {
        return static::prefix(static::encodeString($string, $length));
    }

    public static function decodeString(string $hex): string
    {
        return pack('H*', static::unPrefix($hex));
    }
}
