<?php

namespace Enjin\BlockchainTools\HexNumber;

use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;
use phpseclib\Math\BigInteger;

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
     *
     * @param string $hex hex string
     */
    public function __construct(string $hex)
    {
        $this->value = $this->parseAndValidate($hex);
    }

    /**
     * Pad left of $hex with $string until its length matches $length.
     *
     * @param string $hex
     * @param int|null $length if null HEX_LENGTH of this class is used
     *
     * @return string padded hex leaving the prefix intact if it had one
     */
    public static function padLeft(string $hex, int $length = null): string
    {
        if ($length === null) {
            $length = static::HEX_LENGTH;
        }

        return HexConverter::padLeft($hex, $length, '0');
    }

    /**
     * Pad right of $hex with $string until its length matches $length.
     *
     * @param string $hex
     * @param int|null $length if null HEX_LENGTH of this class is used
     *
     * @return string padded hex leaving the prefix intact if it had one
     */
    public static function padRight(string $hex, int $length = null): string
    {
        if ($length === null) {
            $length = static::HEX_LENGTH;
        }

        return HexConverter::padRight($hex, $length, '0');
    }

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

    public function convertUpTo(int $bitSize): string
    {
        if ($bitSize < static::BIT_SIZE) {
            throw new InvalidArgumentException('Cannot convert up to ' . $bitSize . ' from ' . static::BIT_SIZE . '. Can only convert up to larger bit sizes');
        }

        $length = $bitSize / 4;

        return static::padLeft($this->value, $length);
    }

    public function forceConvertDownToTop(int $bitSize): string
    {
        return $this->convertDownToTop($bitSize, false);
    }

    public function convertDownToTop(int $bitSize, bool $preventDataLoss = true): string
    {
        if ($bitSize > static::BIT_SIZE) {
            throw new InvalidArgumentException('Cannot convert down to ' . $bitSize . ' from ' . static::BIT_SIZE . '. Can only convert down to smaller bit sizes');
        }

        return HexConverter::withPrefixIntact($this->value, function ($hex) use ($bitSize, $preventDataLoss) {
            $length = $bitSize / 4;
            $top = substr($hex, 0, $length);

            if ($preventDataLoss) {
                $removed = substr($hex, $length);
                $nonZeroRemoved = strlen(ltrim($removed, '0'));
                if ($nonZeroRemoved) {
                    throw new InvalidArgumentException('Cannot safely convert down to top of ' . $bitSize . ' from ' . static::BIT_SIZE . ', non-zero bits would be lost. (' . $removed . ') from end of (' . $hex . ')');
                }
            }

            return $top;
        });
    }

    public function forceConvertDownToBottom(int $bitSize): string
    {
        return $this->convertDownToBottom($bitSize, false);
    }

    public function convertDownToBottom(int $bitSize, bool $preventDataLoss = true)
    {
        if ($bitSize > static::BIT_SIZE) {
            throw new InvalidArgumentException('Cannot convert down to ' . $bitSize . ' from ' . static::BIT_SIZE . '. Can only convert down to smaller bit sizes');
        }

        return HexConverter::withPrefixIntact($this->value, function ($hex) use ($bitSize, $preventDataLoss) {
            $length = $bitSize / 4;
            $index = strlen($hex) - $length;
            $bottom = substr($hex, $index);

            if ($preventDataLoss) {
                $removed = substr($hex, 0, $index);
                $nonZeroRemoved = strlen(ltrim($removed, '0'));
                if ($nonZeroRemoved) {
                    throw new InvalidArgumentException('Cannot safely convert down to bottom of ' . $bitSize . ' from ' . static::BIT_SIZE . ', non-zero bits would be lost. (' . $removed . ') from start of (' . $hex . ')');
                }
            }

            return $bottom;
        });
    }

    protected function parseAndValidate(string $hex)
    {
        $value = HexConverter::unPrefix($hex);
        $length = strlen($value);
        $expectedLength = static::HEX_LENGTH;

        if ($length !== $expectedLength) {
            $class = $this->classBaseName();

            throw new InvalidArgumentException("{$class} value provided is invalid. Expected {$expectedLength} characters but has: {$length} (input value: {$hex})");
        }

        return $hex;
    }

    protected static function validateIntRange(string $int)
    {
        $bigInt = new BigInteger($int);

        $min = new BigInteger(static::INT_MIN);
        $lessThanMin = $bigInt->compare($min) < 0;
        if ($lessThanMin) {
            throw new InvalidArgumentException('provided base 10 int(' . $int . ') is less than min value for ' . static::classBaseName() . ' (' . static::INT_MIN . ')');
        }

        $max = new BigInteger(static::INT_MAX);
        $greaterThanMax = $bigInt->compare($max) > 0;
        if ($greaterThanMax) {
            throw new InvalidArgumentException('provided base 10 int(' . $int . ') is greater than max value for ' . static::classBaseName() . ' (' . static::INT_MAX . ')');
        }
    }

    protected static function classBaseName(): string
    {
        return basename(str_replace('\\', '/', static::class));
    }
}
