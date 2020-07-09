<?php

namespace Enjin\BlockchainTools\HexNumber\HexInt;

use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;
use phpseclib\Math\BigInteger;

abstract class BaseHexInt
{
    /**
     * @var string
     */
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $this->parseAndValidate($value);
    }

    public static function padLeft(string $hex): string
    {
        $string = static::isNegative($hex) ? 'f' : '0';

        return HexConverter::padLeft($hex, static::LENGTH, $string);
    }

    public static function padRight(string $hex, string $string): string
    {
        return HexConverter::padRight($hex, static::LENGTH, $string);
    }

    public static function fromInt(string $int)
    {
        $hex = HexConverter::intToHexInt($int, static::LENGTH);

        return new static($hex);
    }

    public function toPrefixed(): string
    {
        return HexConverter::prefix($this->value);
    }

    public function toUnPrefixed(): string
    {
        return HexConverter::unPrefix($this->value);
    }

    /**
     * @return string number in base 10
     */
    public function toDecimal(): string
    {
        return HexConverter::hexIntToInt($this->value, static::INT_MAX);
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

    protected function parseAndValidate(string $hex)
    {
        $value = HexConverter::unPrefix($hex);
        $length = strlen($value);
        $expectedLength = static::LENGTH;

        if ($length !== $expectedLength) {
            $class = basename(str_replace('\\', '/', get_class($this)));

            throw new InvalidArgumentException("{$class} value provided is invalid. Expected {$expectedLength} characters but has: {$length} (input value: {$hex})");
        }

        return $hex;
    }
}
