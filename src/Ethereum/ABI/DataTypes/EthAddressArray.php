<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\DataTypes;

use Enjin\BlockchainTools\HexConverter;

class EthAddressArray
{
    /**
     * Constructor takes an array of addresses to pass here.
     *
     * @param array
     */
    protected function encode(array $addresses)
    {
        $arrayLength = count($addresses);
        $arrayLengthEncoded = HexConverter::intToHexPrefixed($arrayLength);
        $encoded = array_map(function ($address) {
            return EthAddress::encode($address);
        }, $addresses);

        return $arrayLengthEncoded . implode('', $encoded);
    }

    /**
     * An encoded array of addresses, with the array count encoded in the first 32 bytes.
     *
     * @param string
     */
    protected function decode(string $hex)
    {
        $arrayLengthEncoded = substr($hex, 0, 66);
        $arrayLength = HexConverter::hexToUInt($arrayLengthEncoded);

        $decoded = [];
        $dataPosition = 66;
        for ($i = 0; $i < $arrayLength; $i++) {
            $decoded[] = HexConverter::prefix(substr($hex, $dataPosition + 24, 40));
            $dataPosition += 64;
        }

        return $decoded;
    }
}
