<?php

namespace Tests\Unit;

use Enjin\BlockchainTools\BigHex;
use phpseclib\Math\BigInteger;
use stdClass;
use Tests\TestCase;

/**
 * @covers \Enjin\BlockchainTools\BigHex
 */
class BigHexTest extends TestCase
{
    public function testCreateFromStringZero()
    {
        $number = '0';
        $hex = '0';
        $bigHex = new BigHex($hex);

        $this->assertBigHexValues($bigHex, $hex, $number);
    }

    public function testCreateFromString()
    {
        $number = (string) random_int(0, 100000);
        $hex = dechex($number);
        $bigHex = new BigHex($hex);

        $this->assertBigHexValues($bigHex, $hex, $number);
    }

    public function testCreateFromSelfZero()
    {
        $number = '0';
        $hex = '0';
        $bigHex = new BigHex($hex);
        $bigHex2 = new BigHex($bigHex);

        $this->assertBigHexValues($bigHex2, $hex, $number);
    }

    public function testCreateFromSelf()
    {
        $number = (string) random_int(0, 100000);
        $hex = dechex($number);
        $bigHex = new BigHex($hex);
        $bigHex2 = new BigHex($bigHex);

        $this->assertBigHexValues($bigHex2, $hex, $number);
    }

    public function testBytesSymmetry()
    {
        $hex = '1a2b3c4d5e6f';

        $bigHex = BigHex::create($hex);

        $bytes = [
            26,
            43,
            60,
            77,
            94,
            111,
        ];

        $this->assertEquals($bytes, $bigHex->toBytes());

        $bigHex2 = BigHex::createFromBytes($bytes);

        $this->assertEquals($hex, $bigHex2->toStringUnPrefixed());
    }

    public function testCreateFromInvalid()
    {
        $message = 'BigHex constructor input is not a valid hexadecimal string: "invalid_string"';
        $this->assertInvalidArgumentException($message, function () {
            $value = 'invalid_string';
            new BigHex($value);
        });

        $message = 'BigHex constructor input is not valid: null (type: NULL)';
        $this->assertInvalidArgumentException($message, function () {
            $value = null;
            new BigHex($value);
        });

        $message = 'BigHex constructor input is not valid: stdClass (type: object)';
        $this->assertInvalidArgumentException($message, function () {
            $value = new stdClass();
            new BigHex($value);
        });

        $message = 'BigHex constructor input is not valid: true (type: boolean)';
        $this->assertInvalidArgumentException($message, function () {
            $value = true;
            new BigHex($value);
        });

        $message = 'BigHex constructor input is not valid: false (type: boolean)';
        $this->assertInvalidArgumentException($message, function () {
            $value = false;
            new BigHex($value);
        });

        $message = 'BigHex constructor input is not valid: Array (type: array)';
        $this->assertInvalidArgumentException($message, function () {
            $value = [];
            new BigHex($value);
        });

        $message = 'BigHex constructor input is not valid: 999 (type: integer)';
        $this->assertInvalidArgumentException($message, function () {
            $value = 999;
            new BigHex($value);
        });

        $message = 'BigHex constructor input is not valid: 1.23 (type: float)';
        $this->assertInvalidArgumentException($message, function () {
            $value = 1.23;
            new BigHex($value);
        });
    }

    private function assertBigHexValues(BigHex $bigHex, string $hex, string $number): void
    {
        $this->assertEquals('0x' . $hex, $bigHex->toStringPrefixed());
        $this->assertEquals($hex, (string) $bigHex);
        $this->assertEquals($hex, $bigHex->toStringUnPrefixed());

        $bigInt = $bigHex->toBigInt();

        $this->assertInstanceOf(BigInteger::class, $bigInt);
        $this->assertEquals($number, $bigInt->__toString());
    }
}
