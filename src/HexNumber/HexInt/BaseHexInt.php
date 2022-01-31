<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexNumber;
use phpseclib3\Math\BigInteger;

abstract class BaseHexInt extends HexNumber
{
    public static function padLeft(string $hex, int $length = null): string
    {
        if ($length === null) {
            $length = static::HEX_LENGTH;
        }

        $string = static::isNegative($hex) ? 'f' : '0';

        return HexConverter::padLeft($hex, $length, $string);
    }

    /**
     * @param string $int
     *
     * @return static
     */
    public static function fromInt(string $int)
    {
        static::validateIntRange($int);

        $hex = HexConverter::intToHex($int, static::HEX_LENGTH);

        return new static($hex);
    }

    /**
     * @return string number in base 10
     */
    public function toDecimal(): string
    {
        return HexConverter::hexToInt($this->value);
    }

    protected static function isNegative(string $hex): bool
    {
        $num = new BigInteger($hex, -16);

        // $num->is_negative is not to be trusted when using base -16
        return $num->toString()[0] === '-';
    }
}
