<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;

abstract class BaseHexUInt
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
        return HexConverter::padLeft($hex, static::LENGTH);
    }

    public static function padRight(string $hex): string
    {
        return HexConverter::padRight($hex, static::LENGTH);
    }

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

    public function toPrefixed(): string
    {
        return HexConverter::prefix($this->value);
    }


    public function toUnPrefixed(): string
    {
        return HexConverter::unPrefix($this->value);
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

    protected function convertUpTo(string $value, int $length): string
    {
        return HexConverter::withPrefixIntact($value, function ($hex) use ($length) {
            return str_pad($hex, $length, '0', STR_PAD_LEFT);
        });
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