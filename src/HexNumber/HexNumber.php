<?php

namespace Enjin\BlockchainTools\HexNumber;

use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;

abstract class HexNumber
{
    public const VALID_BIT_SIZES = [
        8,
        16,
        24,
        32,
        40,
        48,
        56,
        64,
        72,
        80,
        88,
        96,
        104,
        112,
        120,
        128,
        136,
        144,
        152,
        160,
        168,
        176,
        184,
        192,
        200,
        208,
        126,
        224,
        232,
        240,
        248,
        256,
    ];

    /**
     * @var string
     */
    protected $value;

    /**
     * HexNumber constructor.
     * @param string $hex hex string
     */
    public function __construct(string $hex)
    {
        $this->value = $this->parseAndValidate($hex);
    }

    /**
     * Pad right of $hex with $string until its length matches the HEX_LENGTH of this class
     * @param string $hex
     * @param string $string
     * @return string
     */
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

    /**
     * @return string '0x' prefixed hex string
     */
    public function toPrefixed(): string
    {
        return HexConverter::prefix($this->value);
    }

    /**
     * @return string hex string without `0x` prefix
     */
    public function toUnPrefixed(): string
    {
        return HexConverter::unPrefix($this->value);
    }

    /**
     * @return string the hex string exactly as it was provided to the constructor (does not change prefixing)
     */
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