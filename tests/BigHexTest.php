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
        $i = new BigInteger('1323124');

        $number = (string) random_int(0, 100000);
        $hex = dechex($number);
        $bigHex = new BigHex($hex);

        $this->assertEquals('0x' . $number, $bigHex->toStringPrefixed());
        $this->assertEquals('0x' . $number, (string) $bigHex);
        $this->assertEquals($number, $bigHex->toStringUnPrefixed());

        $bigInt = $bigHex->toBigInt();

        $this->assertInstanceOf(BigInt::class, $bigInt);

        $this->assertEquals($number, $bigInt->toString());
    }
}
