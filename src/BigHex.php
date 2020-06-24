<?php

namespace Enjin\BlockchainTools;

use InvalidArgumentException;

class BigHex
{
    protected $value;

    static public function create($value) : self
    {
        return new BigHex($value);
    }

    public static function isValid(string $str) : bool
    {
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $c = ord($str[$i]);
            if (($i != 0 || $c != 45) && ($c < 48 || $c > 57) && ($c < 65 || $c > 70) && ($c < 97 || $c > 102)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Hexadecimal constructor.
     * @param $value string|int|BigInt|static
     */
    public function __construct($value)
    {
        if ($value instanceof self) {
            $value = $value->toStringUnPrefixed();
        } else if ($value instanceof BigInt) {
            $value = $value->toHexStr();
        } else if (is_int($value)) {
            $value = (new BigInt($value))->toHexStr();
        } else if (is_string($value)) {
            $value = HexConverter::unPrefix($value);
        } else {
            throw new InvalidArgumentException('value provided is not a valid hexadecimal: ' . $value);
        }

        if (!is_string($value) || !self::isValid($value)) {
            throw new InvalidArgumentException('value provided is not a valid hexadecimal string: ' . $value);
        }

        $this->value = $value;
    }

    public function toBigInt() : BigInt
    {
        return new BigInt($this->value, 16);
    }

    public function toBytes() : array
    {
        return unpack('C*', hex2bin($this->value));
    }

    public function toStringUnPrefixed() : string
    {
        return $this->value;
    }

    public function toStringPrefixed() : string
    {
        return '0x' . $this->value;
    }

    public function __toString()
    {
        return $this->toStringPrefixed();
    }
}
