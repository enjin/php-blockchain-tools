<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthBytes32
{
    public static function encode(array $bytes)
    {
        return HexConverter::bytesToHexPrefixed($bytes);
    }

    public static function decode(string $hex): array
    {
        return HexConverter::hexToBytes($hex);
    }
}
