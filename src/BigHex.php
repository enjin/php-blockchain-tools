<?php

namespace Enjin\BlockchainTools;

use InvalidArgumentException;
use phpseclib3\Math\BigInteger;

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

    public static function create(string $value): self
    {
        return new self($value);
    }

    public static function isValidHex(string $str): bool
    {
        return ctype_xdigit($str);
    }

    public function toBigInt(): BigInteger
    {
        return new BigInteger($this->value, 16);
    }

    public function toStringUnPrefixed(): string
    {
        return $this->value;
    }

    public function toStringPrefixed(): string
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
