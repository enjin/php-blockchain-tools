<?php

namespace Enjin\BlockchainTools\HexNumber;

use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;

abstract class BaseHexNumber
{
    /**
     * @var string
     */
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $this->parseAndValidate($value);
    }

    public static function padRight(string $hex, string $string = '0'): string
    {
        return HexConverter::padRight($hex, static::HEX_LENGTH, $string);
    }

    /**
     * @param string $int
     *
     * @return static
     */
    abstract public static function fromInt(string $int);

    /**
     * @param string $hex
     *
     * @return static
     */
    public static function fromHex(string $hex)
    {
        return new static($hex);
    }

    /**
     * @return string number in base 10
     */
    abstract public function toDecimal(): string;

    public function toPrefixed(): string
    {
        return HexConverter::prefix($this->value);
    }

    public function toUnPrefixed(): string
    {
        return HexConverter::unPrefix($this->value);
    }

    public function toHex(): string
    {
        return $this->value;
    }

    protected function parseAndValidate(string $hex)
    {
        $value = HexConverter::unPrefix($hex);
        $length = strlen($value);
        $expectedLength = static::HEX_LENGTH;

        if ($length !== $expectedLength) {
            $class = basename(str_replace('\\', '/', get_class($this)));

            throw new InvalidArgumentException("{$class} value provided is invalid. Expected {$expectedLength} characters but has: {$length} (input value: {$hex})");
        }

        return $hex;
    }
}
