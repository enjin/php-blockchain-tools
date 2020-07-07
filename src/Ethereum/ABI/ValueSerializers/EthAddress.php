<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers;

use Enjin\BlockchainTools\HexConverter;

class EthAddress
{
    public static function encode(string $address)
    {
        $address = HexConverter::unPrefix($address);

        return str_pad($address, 64, '0', STR_PAD_LEFT);
    }

    public static function decode(string $value)
    {
        return HexConverter::prefix(substr($value, 24));
    }
}
