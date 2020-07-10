<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexNumber;
use InvalidArgumentException;

abstract class BaseHexUInt extends HexNumber
{
    public static function padLeft(string $hex, string $string = '0'): string
    {
        return HexConverter::padLeft($hex, static::HEX_LENGTH, $string);
    }

    /**
     * @param string $int
     *
     * @return static
     */
    public static function fromUInt(string $int)
    {
        static::validateIntRange($int);

        $hex = HexConverter::intToHexUInt($int, static::HEX_LENGTH);

        return new static($hex);
    }

    /**
     * @return string number in base 10
     */
    public function toDecimal(): string
    {
        return HexConverter::hexToUInt($this->value);
    }

    public function convertUpToBitSize(int $bitSize): string
    {
        $method = 'convertUpToUInt' . $bitSize;

        if (!method_exists($this, $method)) {
            throw new InvalidArgumentException('Cannot convert up to uInt' . $bitSize . ' from uInt' . static::BIT_SIZE);
        }
        return $this->{$method}();
    }

    public function convertDownToTopBitSize(int $bitSize): string
    {
        $method = 'toHexUInt' . $bitSize . 'Top';

        if (!method_exists($this, $method)) {
            throw new InvalidArgumentException('Cannot convert down to uInt' . $bitSize . ' from uInt' . static::BIT_SIZE);
        }
        return $this->{$method}();
    }

    public function convertDownToBottomBitSize(int $bitSize): string
    {
        $method = 'toHexUInt' . $bitSize . 'Bottom';

        if (!method_exists($this, $method)) {
            throw new InvalidArgumentException('Cannot convert down to uInt' . $bitSize . ' from uInt' . static::BIT_SIZE);
        }
        return $this->{$method}();
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
