<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthUint256Array
{
    public static function encode(array $integers)
    {
        $arrayLength = count($integers);
        $arrayLengthEncoded = HexConverter::intToHexPrefixed($arrayLength, 64);

        $encodedValue = $arrayLengthEncoded;
        foreach ($integers as $uInt256) {
            $encodedValue .= HexConverter::intToHex($arrayLength, 64);
        }

        return $encodedValue;
    }

    /**
     * Takes an encoded array of uint256s, with the encoded array length as the first 32 bytes.
     *
     * @param string
     */
    public static function decode(string $hex)
    {
        $arrayLengthEncoded = substr($hex, 0, 66);
        $arrayLength = HexConverter::hexToInt($arrayLengthEncoded);

        $decoded = [];
        $dataPosition = 66;
        for ($i = 0; $i < $arrayLength; $i++) {
            $value = substr($hex, $dataPosition, 64);
            $decoded[] = HexConverter::intToHexPrefixed($value, 64);
            $dataPosition += 64;
        }

        return $decoded;
    }
}
