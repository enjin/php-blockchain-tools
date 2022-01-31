<?php

namespace Enjin\BlockchainTools\HexNumber;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\Concerns\ConvertsByBitSize;
use InvalidArgumentException;
use phpseclib3\Math\BigInteger;

abstract class HexNumber
{
    use ConvertsByBitSize;

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

    /**
     * @param int $characters number of characters to take from top (left) of hex
     *
     * @return string
     */
    public function top(int $characters): string
    {
        $length = strlen($this->value);
        if ($length < $characters) {
            throw new InvalidArgumentException('Cannot take ' . $characters . ' characters from top of string with length: ' . $length);
        }

        $message = 'Cannot safely convert down to top ' . $characters . ' characters';

        return $this->topCharacters($characters, false, $message);
    }

    /**
     * @param int $characters number of characters to take from bottom (right) of hex
     *
     * @return string
     */
    public function bottom(int $characters): string
    {
        $length = strlen($this->value);
        if ($length < $characters) {
            throw new InvalidArgumentException('Cannot take ' . $characters . ' characters from bottom of string with length: ' . $length);
        }

        $message = 'Cannot safely convert down to bottom ' . $characters . ' characters';

        return $this->bottomCharacters($characters, false, $message);
    }

    protected function topCharacters(int $length, bool $preventDataLoss, string $exceptionMessage): string
    {
        return HexConverter::withPrefixIntact($this->value, function ($hex) use (
            $length,
            $preventDataLoss,
            $exceptionMessage
        ) {
            $top = substr($hex, 0, $length);

            if ($preventDataLoss) {
                $removed = substr($hex, $length);
                $nonZeroRemoved = strlen(ltrim($removed, '0'));
                if ($nonZeroRemoved) {
                    throw new InvalidArgumentException($exceptionMessage . ', non-zero bits would be lost. (' . $removed . ') from end of (' . $hex . ')');
                }
            }

            return $top;
        });
    }

    protected function bottomCharacters(int $length, bool $preventDataLoss, string $exceptionMessage): string
    {
        return HexConverter::withPrefixIntact($this->value, function ($hex) use (
            $length,
            $preventDataLoss,
            $exceptionMessage
        ) {
            $index = strlen($hex) - $length;
            $bottom = substr($hex, $index);

            if ($preventDataLoss) {
                $removed = substr($hex, 0, $index);
                $nonZeroRemoved = strlen(ltrim($removed, '0'));
                if ($nonZeroRemoved) {
                    throw new InvalidArgumentException($exceptionMessage . ', non-zero bits would be lost. (' . $removed . ') from start of (' . $hex . ')');
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
