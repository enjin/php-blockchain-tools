<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexNumber;
use phpseclib\Math\BigInteger;

abstract class HexInt extends HexNumber
{
    public static function padLeft(string $hex): string
    {
        $string = static::isNegative($hex) ? 'f' : '0';

        return HexConverter::padLeft($hex, static::HEX_LENGTH, $string);
    }

    /**
     * @param string $int
     *
     * @return static
     */
    public static function fromInt(string $int)
    {
        $hex = HexConverter::intToHexInt($int, static::HEX_LENGTH);

        return new static($hex);
    }

    /**
     * @return string number in base 10
     */
    public function toDecimal(): string
    {
        return HexConverter::hexIntToInt($this->value);
    }

    protected function convertUpTo(string $value, int $length): string
    {
        $string = static::isNegative($value) ? 'f' : '0';

        return HexConverter::padLeft($value, $length, $string);
    }

    protected static function isNegative(string $hex): bool
    {
        $num = new BigInteger($hex, -16);

        return $num->toString()[0] === '-';
    }
}
