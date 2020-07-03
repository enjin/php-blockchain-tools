<?php

namespace Enjin\BlockchainTools\HexIntConverter;

use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;

abstract class HexUInt
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var int
     */
    protected $stringLength;

    public function __construct(string $value)
    {
        $this->value = $this->parseAndValidate($value);
    }

    public function toBase10(): string
    {
        return HexConverter::hexToInt($this->value);
    }

    public function toDecimal(): string
    {
        return $this->toBase10();
    }

    protected function parseAndValidate(string $hex)
    {
        $value = HexConverter::unPrefix($hex);
        $length = strlen($value);
        $expectedLength = $this->stringLength;

        if ($length !== $expectedLength) {
            $class = basename(str_replace('\\', '/', get_class($this)));

            throw new InvalidArgumentException("{$class} value provided is invalid. Expected {$expectedLength} characters but has: {$length} (input value: {$hex})");
        }

        return $value;
    }

    protected function convertUpTo(string $value, int $length)
    {
        $value = str_pad($value, $length, '0', STR_PAD_LEFT);

        return HexConverter::prefix($value);
    }

    protected function convertUpToUInt16(string $value)
    {
        return $this->convertUpTo($value, 4);
    }

    protected function convertUpToUInt32(string $value)
    {
        return $this->convertUpTo($value, 8);
    }

    protected function convertUpToUInt64(string $value)
    {
        return $this->convertUpTo($value, 16);
    }

    protected function convertUpToUInt128(string $value)
    {
        return $this->convertUpTo($value, 32);
    }

    protected function convertUpToUInt256(string $value)
    {
        return $this->convertUpTo($value, 64);
    }

    protected function convertDownToTop(string $value, int $length)
    {
        $value = substr($value, 0, $length);

        return HexConverter::prefix($value);
    }

    protected function convertDownToBottom(string $value, int $length)
    {
        $value = substr($value, -$length);

        return HexConverter::prefix($value);
    }

    protected function covertDownToUInt8Top(string $value)
    {
        return $this->convertDownToTop($value, 2);
    }

    protected function covertDownToUInt8Bottom(string $value)
    {
        return $this->convertDownToBottom($value, 2);
    }

    protected function covertDownToUInt16Top(string $value)
    {
        return $this->convertDownToTop($value, 4);
    }

    protected function covertDownToUInt16Bottom(string $value)
    {
        return $this->convertDownToBottom($value, 4);
    }

    protected function covertDownToUInt32Top(string $value)
    {
        return $this->convertDownToTop($value, 8);
    }

    protected function covertDownToUInt32Bottom(string $value)
    {
        return $this->convertDownToBottom($value, 8);
    }

    protected function covertDownToUInt64Top(string $value)
    {
        return $this->convertDownToTop($value, 16);
    }

    protected function covertDownToUInt64Bottom(string $value)
    {
        return $this->convertDownToBottom($value, 16);
    }

    protected function covertDownToUInt128Top(string $value)
    {
        return $this->convertDownToTop($value, 32);
    }

    protected function covertDownToUInt128Bottom(string $value)
    {
        return $this->convertDownToBottom($value, 32);
    }
}
