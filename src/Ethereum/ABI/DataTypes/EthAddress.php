<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthAddress
{
    public static function encode(string $address)
    {
        $address = HexConverter::prefix($address);

        return str_pad($address, 64, '0', STR_PAD_LEFT);
    }

    public static function decode(string $value)
    {
        return HexConverter::prefix(substr($value, 26));
    }
}
