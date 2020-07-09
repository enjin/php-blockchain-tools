<?php

namespace Enjin\BlockchainTools\HexInt;

use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;

abstract class BaseHexInt
{
    /**
     * @var string
     */
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $this->parseAndValidate($value);
    }

    public static function padLeft(string $hex)
    {
        return HexConverter::padLeft($hex, static::LENGTH);
    }

    public static function padRight(string $hex)
    {
        return HexConverter::padRight($hex, static::LENGTH);
    }

    /**
     * @return string number in base 10
     */
    public function toDecimal(): string
    {
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
}
