<?php

namespace Enjin\BlockchainTools;

use Closure;
use phpseclib3\Math\BigInteger;

class HexConverter
{
    /**
     * Add the '0x' prefix to a string if it does not have the prefix.
     *
     * @param string $value
     *
     * @return string
     */
    public static function prefix(string $value): string
    {
        if (!self::hasPrefix($value)) {
            $value = '0x' . $value;
        }

        return $value;
    }

    /**
     * Remove the '0x' prefix from a string if it has the prefix.
     *
     * @param string $value
     *
     * @return string
     */
    public static function unPrefix(string $value): string
    {
        if (self::hasPrefix($value)) {
            $value = substr($value, 2);
        }

        return $value;
    }

    /**
     * Check if a string has the prefix '0x'.
     *
     * @param string $value
     *
     * @return bool true if prefixed
     */
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

    /**
     * Convert base 10 signed int to a hex signed int.
     *
     * @param string $int base 10 signed int
     * @param int|null $length hex string length to pad on left
     *
     * @return string hex signed int
     */
    public static function intToHex(string $int, int $length = null): string
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

    /**
     * Convert base 10 signed int to a hex signed int.
     *
     * @param string $int base 10 signed int
     * @param int|null $length hex string length to pad on left
     *
     * @return string hex signed int
     */
    public static function intToHexPrefixed(string $int, int $length = null): string
    {
        return '0x' . self::intToHex($int, $length);
    }

    /**
     * Convert a hex signed int to a base 10 signed int.
     *
     * @param string $hex hex signed int
     *
     * @return string base 10 signed int
     */
    public static function hexToInt(string $hex): string
    {
        $hex = static::unPrefix($hex);

        // -16 negative indicates that hex is encoded with two's complement
        $value = new BigInteger($hex, -16);

        return $value->toString();
    }

    /**
     * Convert base 10 unsigned int to a hex unsigned int.
     *
     * @param string $int base 10 unsigned int
     * @param int|null $length hex string length to pad on left
     *
     * @return string hex unsigned int
     */
    public static function uintToHex(string $int, int $length = null): string
    {
        $hex = (new BigInteger($int))->toHex();

        if ($length) {
            $hex = str_pad($hex, $length, '0', STR_PAD_LEFT);
        }

        return $hex;
    }

    public static function uintToHexPrefixed(string $int, int $length = null): string
    {
        return '0x' . self::uintToHex($int, $length);
    }

    /**
     * Convert hex unsigned int to a base 10 unsigned int.
     *
     * @param string $hex hex unsigned int
     *
     * @return string base 10 unsigned int
     */
    public static function hexToUInt(string $hex): string
    {
        $hex = self::unPrefix($hex);

        return (string) (new BigInteger($hex, 16))->toString();
    }

    public static function hexToBytes(string $hex): array
    {
        $hex = self::unPrefix($hex);
        if (ltrim($hex, '0') === '') {
            return [];
        }
        $bin = hex2bin($hex);
        $array = unpack('C*', $bin);

        return array_values($array);
    }

    public static function bytesToHex(array $bytes): string
    {
        if (!$bytes) {
            return '00';
        }

        $bytes = array_map('chr', $bytes);
        $bytes = implode('', $bytes);

        return bin2hex($bytes);
    }

    public static function bytesToHexPrefixed(array $bytes): string
    {
        return '0x' . static::bytesToHex($bytes);
    }

    /**
     * pad a hex string on the left leaving the prefix intact if it has one.
     *
     * @param string $hex
     * @param int $length
     * @param string $string
     *
     * @return string
     */
    public static function padLeft(string $hex, int $length, string $string = '0'): string
    {
        return static::withPrefixIntact($hex, function ($hex) use ($length, $string) {
            return str_pad($hex, $length, $string, STR_PAD_LEFT);
        });
    }

    /**
     * pad a hex string on the right leaving the prefix intact if it has one.
     *
     * @param string $hex
     * @param int $length
     * @param string $string
     *
     * @return string
     */
    public static function padRight(string $hex, int $length, string $string = '0'): string
    {
        return static::withPrefixIntact($hex, function ($hex) use ($length, $string) {
            return str_pad($hex, $length, $string, STR_PAD_RIGHT);
        });
    }

    /**
     * mutate a hex string keeping the prefix intact if it has one.
     *
     * @param string $hex
     * @param Closure $callback performs the mutation, passed a single argument: the unprefixed hex
     *
     * @return string mutated string with prefix intact if it has one
     */
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
