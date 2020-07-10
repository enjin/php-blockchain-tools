<?php

namespace Enjin\BlockchainTools\HexNumber\HexUInt;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexNumber;

abstract class BaseHexUInt extends HexNumber
{
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
}
