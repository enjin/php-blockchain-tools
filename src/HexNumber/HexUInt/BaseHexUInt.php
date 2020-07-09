<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\BaseHexNumber;

abstract class BaseHexUInt extends BaseHexNumber
{
    public static function padLeft(string $hex, string $string = '0'): string
    {
        return HexConverter::padLeft($hex, static::LENGTH, $string);
    }

    /**
     * @param string $int
     *
     * @return static
     */
    public static function fromInt(string $int)
    {
        $hex = HexConverter::intToHexUInt($int, static::LENGTH);

        return new static($hex);
    }

    /**
     * @return string number in base 10
     */
    public function toDecimal(): string
    {
        return HexConverter::hexToUInt($this->value);
    }

    protected function convertUpTo(string $value, int $length): string
    {
        return HexConverter::padLeft($value, $length);
    }

    protected function convertDownToTop(string $value, int $length): string
    {
        return HexConverter::withPrefixIntact($value, function ($hex) use ($length) {
            return substr($hex, 0, $length);
        });
    }

    protected function convertDownToBottom(string $value, int $length): string
    {
        return HexConverter::withPrefixIntact($value, function ($hex) use ($length) {
            return substr($hex, -$length);
        });
    }
}
