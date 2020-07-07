<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers;

use Enjin\BlockchainTools\HexConverter;

class EthBytes
{
    public static function encode(array $bytes)
    {
        if ($bytes) {
            return HexConverter::bytesToHex($bytes);
        }

        return HexConverter::intToHexUInt('0', 64);
    }

    public static function decode(string $hex): array
    {
        if (!$hex) {
            return [];
        }
        // @TODO right trim zeroes?
        return HexConverter::hexToBytes($hex);
    }
}
