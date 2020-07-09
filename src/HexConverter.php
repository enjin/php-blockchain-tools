<?php

namespace Enjin\BlockchainTools;

use Closure;
use phpseclib\Math\BigInteger;

class HexConverter
{
    public static function prefix(string $value): string
    {
        if (!self::hasPrefix($value)) {
            $value = '0x' . $value;
        }

        return $value;
    }

    public static function unPrefix(string $value): string
    {
        if (self::hasPrefix($value)) {
            $value = substr($value, 2);
        }

        return $value;
    }

    public static function hasPrefix(string $value): bool
    {
        return substr($value, 0, 2) == '0x';
    }

    public static function stringToHex(string $string, int $length = null): string
    {
        $hex = implode('', unpack('H*', $string));

        $padLength = 0;

        if ($length) {
            $padLength = strlen($hex) + $length - strlen($hex) % $length;
        }

        return str_pad($hex, $padLength, '0');
    }

    public static function stringToHexPrefixed(string $string, int $length = null): string
    {
        return '0x' . static::stringToHex($string, $length);
    }

    public static function hexToString(string $hex): string
    {
        return (string) pack('H*', static::unPrefix($hex));
    }

    public static function intToHexInt(string $int, int $length = null): string
    {
        $isNegative = $int[0] === '-';
        $value = new BigInteger($int, 10);
        $hex = $value->toHex(true);

        if ($length) {
            $pad = $isNegative ? 'f' : '0';
            $hex = str_pad($hex, $length, $pad, STR_PAD_LEFT);
        }

        return $hex;
    }

    public static function intToHexIntPrefixed(string $int, int $length = null): string
    {
        return '0x' . self::intToHexInt($int, $length);
    }

    /**
     * Convert from a hex signed int to a php string of that number in base 10
     *
     * @param string $hex
     * @return string base 10 value
     */
    public static function hexIntToInt(string $hex): string
    {
        $hex = static::unPrefix($hex);

        // -16 negative indicates that hex is encoded with two's complement
        $value = new BigInteger($hex, -16);

        return $value->toString();
    }

    public static function intToHexUInt(string $int, int $length = null): string
    {
        $hex = (new BigInteger($int))->toHex();

        if ($length) {
            $hex = str_pad($hex, $length, '0', STR_PAD_LEFT);
        }

        return $hex;
    }

    public static function intToHexUIntPrefixed(string $int, int $length = null): string
    {
        return '0x' . self::intToHexUInt($int, $length);
    }

    public static function hexToUInt(string $hex): string
    {
        $hex = self::unPrefix($hex);

        return (string) (new BigInteger($hex, 16))->toString();
    }

    public static function hexToBytes(string $hex): array
    {
        return BigHex::create($hex)->toBytes();
    }

    public static function bytesToHex(array $bytes): string
    {
        return BigHex::createFromBytes($bytes)->toStringUnPrefixed();
    }

    public static function bytesToHexPrefixed(array $bytes): string
    {
        return '0x' . static::bytesToHex($bytes);
    }

    public static function padLeft(string $hex, int $length, string $string = '0'): string
    {
        return static::withPrefixIntact($hex, function ($hex) use ($length, $string) {
            return str_pad($hex, $length, $string, STR_PAD_LEFT);
        });
    }

    public static function padRight(string $hex, int $length, string $string = '0'): string
    {
        return static::withPrefixIntact($hex, function ($hex) use ($length, $string) {
            return str_pad($hex, $length, $string, STR_PAD_RIGHT);
        });
    }

    public static function withPrefixIntact(string $hex, Closure $callback)
    {
        $hasPrefix = static::hasPrefix($hex);
        if ($hasPrefix) {
            $hex = substr($hex, 2);
        }

        $value = $callback($hex);

        if ($hasPrefix) {
            $value = '0x' . $value;
        }

        return $value;
    }
}
