<?php

namespace Enjin\BlockchainTools;

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
        $isNegative = strpos($int, '-') === 0;
        $value = (new BigInteger($int, 10))->abs();

        $hex = static::bigIntegerToHex($value);

        if ($length) {
            $hex = str_pad($hex, $length - 2, '0', STR_PAD_LEFT);
        }

        if ($isNegative) {
            $hex = 'ff' . $hex;
        } else {
            $hex = '00' . $hex;
        }

        return $hex;
    }

    public static function intToHexPrefixed(string $int, int $length = null): string
    {
        return '0x' . self::intToHexInt($int, $length);
    }

    public static function intToHexUInt(string $int, int $length = null): string
    {
        $hex = static::bigIntegerToHex(new BigInteger($int));

        if ($length) {
            $hex = str_pad($hex, $length, '0', STR_PAD_LEFT);
        }

        return $hex;
    }

    public static function uIntToHexPrefixed(string $int, int $length = null): string
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

    public static function bigIntegerToHex(BigInteger $number): string
    {
        $value = $number->toHex(true);
        $value = ltrim($value, '0');

        if ($value === '') {
            return '0';
        }

        return $value;
    }
}
