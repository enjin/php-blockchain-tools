<?php

namespace Enjin\BlockchainTools;

use Brick\Math\BigInteger;
use InvalidArgumentException;

class BigHex
{
    protected $value;

    /**
     * Hexadecimal constructor.
     *
     * @param $value string|BigInteger|static
     */
    public function __construct($value)
    {
        if (is_string($value)) {
            $value = HexConverter::unPrefix($value);
            if (!self::isValidHex($value)) {
                throw new InvalidArgumentException("BigHex constructor input is not a valid hexadecimal string: \"{$value}\"");
            }
        } elseif ($value instanceof self) {
            $value = $value->toStringUnPrefixed();
        } elseif ($value instanceof BigInteger) {
            $value = $value->toBase(16);
        } else {
            $value = $this->valueToErrorString($value);

            throw new InvalidArgumentException('BigHex constructor input is not valid: ' . $value);
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->toStringUnPrefixed();
    }

    public static function createFromInt($integer) : self
    {
        $value = BigInteger::fromBase($integer, 10)->toBase(16);

        return new self($value);
    }

    public static function createFromBytes(array $bytes) : self
    {
        $bytes = array_map('chr', $bytes);
        $bytes = implode('', $bytes);

        return new self(bin2hex($bytes));
    }

    public static function create(string $value) : self
    {
        return new self($value);
    }

    public static function isValidHex(string $str) : bool
    {
        return ctype_xdigit($str);
    }

    public function toBigInt() : BigInteger
    {
        return BigInteger::fromBase($this->value, 16);
    }

    public function toBytes() : array
    {
        $bin = hex2bin($this->value);
        $array = unpack('C*', $bin);

        return array_values($array);
    }

    public function toStringUnPrefixed() : string
    {
        return $this->value;
    }

    public function toStringPrefixed() : string
    {
        return '0x' . $this->value;
    }

    private function valueToErrorString($value)
    {
        $normalized = '';
        if (is_object($value)) {
            $normalized = get_class($value);
        } elseif ($value === null) {
            $normalized = 'null';
        } elseif (is_bool($value)) {
            $normalized = $value ? 'true' : 'false';
        } elseif (is_array($value)) {
            $normalized = 'Array';
        } elseif (is_int($value)) {
            $normalized = (string) $value;
        } elseif (is_float($value)) {
            $normalized = (string) $value;
        }

        $type = gettype($value);
        if ($type === 'double') {
            $type = 'float';
        }

        return $normalized . ' (type: ' . $type . ')';
    }
}
