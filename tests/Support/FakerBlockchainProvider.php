<?php

namespace Tests\Support;

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

    public function uint256()
    {
        $max = '115792089237316195423570985008687907853269984665640564039457584007913129639935';

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

            $number = str_pad($number, $chunkSize, 0, STR_PAD_LEFT);
            $output .= $number;
        }
    }
}
