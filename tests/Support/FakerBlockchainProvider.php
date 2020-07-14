<?php

namespace Tests\Support;

use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt128;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;
use Faker\Provider\Base;

class FakerBlockchainProvider extends Base
{
    public function transactionId()
    {
        return $this->generator->regexify('0x[0-9A-Fa-f]{64}');
    }

    public function ethAddress()
    {
        return $this->generator->regexify('0x[0-9A-Fa-f]{40}');
    }

    public function uint128()
    {
        $max = HexUInt128::INT_MAX;

        return $this->bigNumberBetween(0, $max);
    }

    public function uint256()
    {
        $max = HexUInt256::INT_MAX;

        return $this->bigNumberBetween(0, $max);
    }

    public function bigNumberBetween(string $min, string $max, int $chunkSize = 8)
    {
        $chunks = chunk_split($max, $chunkSize, ',');
        $chunks = trim($chunks, ',');
        $chunks = explode(',', $chunks);
        $output = '';
        foreach ($chunks as $chunk) {
            $number = $this->generator->numberBetween($min, $chunk);
            $chunkLength = strlen($chunk);
            $number = str_pad($number, $chunkLength, 0, STR_PAD_LEFT);
            $output .= $number;
        }

        return $output;
    }
}
