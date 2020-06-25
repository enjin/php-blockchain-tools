<?php

namespace Tests\Unit;

use Brick\Math\BigInteger;
use Enjin\BlockchainTools\BigHex;
use InvalidArgumentException;
use stdClass;
use Tests\TestCase;

/**
 * @covers \Enjin\BlockchainTools\BigHex
 */
class BigHexTest extends TestCase
{
    public function testCreateFromString()
    {
        $number = (string) random_int(0, 100000);
        $hex = dechex($number);
        $bigHex = new BigHex($hex);

        $this->assertBigHexValues($bigHex, $hex, $number);
    }

    public function testCreateFromSelf()
    {
        $number = (string) random_int(0, 100000);
        $hex = dechex($number);
        $bigHex = new BigHex($hex);
        $bigHex2 = new BigHex($bigHex);

        $this->assertBigHexValues($bigHex2, $hex, $number);
    }

    public function testCreateFromBigInteger()
    {
        $number = (string) random_int(0, 100000);
        $bigInt = BigInteger::fromBase($number, 10);
        $hex = $bigInt->toBase(16);
        $bigHex = new BigHex($bigInt);

        $this->assertBigHexValues($bigHex, $hex, $number);
    }

    public function testCreateFromInt()
    {
        $number = (string) random_int(0, 100000);
        $hex = dechex($number);
        $bigHex = BigHex::createFromInt($number);

        $this->assertBigHexValues($bigHex, $hex, $number);
    }

    public function testBytesSymetry()
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
        $value = 'invalid_string';
        $message = 'BigHex constructor input is not a valid hexadecimal string: "invalid_string"';
        $this->assertInvalidArgumentException($value, $message);

        $value = null;
        $message = 'BigHex constructor input is not valid: null (type: NULL)';
        $this->assertInvalidArgumentException($value, $message);

        $value = new stdClass();
        $message = 'BigHex constructor input is not valid: stdClass (type: object)';
        $this->assertInvalidArgumentException($value, $message);

        $value = true;
        $message = 'BigHex constructor input is not valid: true (type: boolean)';
        $this->assertInvalidArgumentException($value, $message);

        $value = false;
        $message = 'BigHex constructor input is not valid: false (type: boolean)';
        $this->assertInvalidArgumentException($value, $message);

        $value = [];
        $message = 'BigHex constructor input is not valid: Array (type: array)';
        $this->assertInvalidArgumentException($value, $message);

        $value = 999;
        $message = 'BigHex constructor input is not valid: 999 (type: integer)';
        $this->assertInvalidArgumentException($value, $message);

        $value = 1.23;
        $message = 'BigHex constructor input is not valid: 1.23 (type: float)';
        $this->assertInvalidArgumentException($value, $message);
    }

    private function assertInvalidArgumentException($value, string $message)
    {
        try {
            new BigHex($value);
            $this->fail('failed to throw expected exception: InvalidArgumentException, with message' . $message);
        } catch (InvalidArgumentException $e) {
            $this->assertEquals($message, $e->getMessage());
        }
    }

    private function assertBigHexValues(BigHex $bigHex, string $hex, string $number) : void
    {
        $this->assertEquals('0x' . $hex, $bigHex->toStringPrefixed());
        $this->assertEquals('0x' . $hex, (string) $bigHex);
        $this->assertEquals($hex, $bigHex->toStringUnPrefixed());

        $bigInt = $bigHex->toBigInt();

        $this->assertInstanceOf(BigInteger::class, $bigInt);
        $this->assertEquals($number, $bigInt->__toString());
        $this->assertEquals($hex, $bigInt->toBase(16));
    }
}
