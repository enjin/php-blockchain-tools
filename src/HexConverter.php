<?php

namespace Enjin\BlockchainTools;

use Brick\Math\BigInteger;

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

    public static function intToHex(string $int): string
    {
        return BigHex::createFromInt($int)->toStringUnPrefixed();
    }

    public static function intToHexPrefixed(string $int): string
    {
        return '0x' . self::intToHex($int);
    }

    public static function hexToInt(string $hex): string
    {
        $hex = HexConverter::unPrefix($hex);

        return (string) BigInteger::fromBase($hex, 16)->toBase(10);
    }

    public static function uint256To128AsHexTop(string $uInt256): string
    {
        $hex = self::uInt256ToHex($uInt256);

        return substr($hex, 0, 16);
    }

    public static function uint256To128AsHexTopPrefixed(string $uInt256): string
    {
        return '0x' . self::uint256To128AsHexTop($uInt256);
    }

    public static function uint256To128AsHexBottom(string $uInt256): string
    {
        $hex = self::uInt256ToHex($uInt256);

        return substr($hex, 48);
    }

    public static function uint256To128AsHexBottomPrefixed(string $uInt256): string
    {
        return '0x' . self::uint256To128AsHexBottom($uInt256);
    }

    public static function uInt256ToHex(string $uInt256): string
    {
        $hex = BigInteger::fromBase($uInt256, 10)->toBase(16);

        return str_pad($hex, 64, '0', STR_PAD_LEFT);
    }

    public static function uInt256ToHexPrefixed(string $uInt256): string
    {
        return '0x' . self::uInt256ToHex($uInt256);
    }
}
