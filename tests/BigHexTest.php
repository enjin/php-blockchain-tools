<?php

namespace Tests\Unit;

use BI\BigInteger;
use Enjin\BlockchainTools\BigHex;
use Enjin\BlockchainTools\BigInt;
use Tests\TestCase;

class BigHexTest extends TestCase
{
    public function testCreateFromString()
    {
        $number = (string) random_int(0, 100000);
        $hex = dechex($number);
        $bigHex = new BigHex($hex);

        $this->assertEquals('0x' . $hex, $bigHex->toStringPrefixed());
        $this->assertEquals('0x' . $hex, (string) $bigHex);
        $this->assertEquals($hex, $bigHex->toStringUnPrefixed());

        $bigInt = $bigHex->toBigInt();

        $this->assertInstanceOf(BigInt::class, $bigInt);

        $this->assertEquals($number, $bigInt->toString());
    }
}
