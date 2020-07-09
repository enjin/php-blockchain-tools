<?php

namespace Tests\Unit\HexUInt;

use Enjin\BlockchainTools\HexNumber\HexUInt;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt32;
use Tests\TestCase;

class HexUInt32Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1234567';
        $expectedMessage = 'HexUInt32 value provided is invalid. Expected 8 characters but has: 7 (input value: 1234567)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUInt::fromHexUInt32($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt32($value);
        });

        $value = '123456789';
        $expectedMessage = 'HexUInt32 value provided is invalid. Expected 8 characters but has: 9 (input value: 123456789)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUInt::fromHexUInt32($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt32($value);
        });
    }

    public function test32To8Top()
    {
        $value = str_pad('12', 8, '0', STR_PAD_RIGHT);
        $expected = '12';

        $actual = HexUInt::fromHexUInt32($value)->toHexUInt8Top();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt32('0x' . $value)->toHexUInt8Top();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt32($value))->toHexUInt8Top();
        $this->assertEquals($expected, $actual);
    }

    public function test32To8Bottom()
    {
        $value = str_pad('78', 8, '0', STR_PAD_LEFT);
        $expected = '78';

        $actual = HexUInt::fromHexUInt32($value)->toHexUInt8Bottom();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt32('0x' . $value)->toHexUInt8Bottom();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt32($value))->toHexUInt8Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test32To16Top()
    {
        $value = str_pad('1234', 8, '0', STR_PAD_RIGHT);
        $expected = '1234';

        $actual = HexUInt::fromHexUInt32($value)->toHexUInt16Top();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt32('0x' . $value)->toHexUInt16Top();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt32($value))->toHexUInt16Top();
        $this->assertEquals($expected, $actual);
    }

    public function test32To16Bottom()
    {
        $value = str_pad('5678', 8, '0', STR_PAD_LEFT);
        $expected = '5678';

        $actual = HexUInt::fromHexUInt32($value)->toHexUInt16Bottom();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt32('0x' . $value)->toHexUInt16Bottom();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt32($value))->toHexUInt16Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test32To64()
    {
        $value = '12345678';
        $expected = '0000000012345678';

        $actual = HexUInt::fromHexUInt32($value)->toHexUInt64();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt32('0x' . $value)->toHexUInt64();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt32($value))->toHexUInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test32To128()
    {
        $value = '12345678';
        $expected = '00000000000000000000000012345678';

        $actual = HexUInt::fromHexUInt32($value)->toHexUInt128();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt32('0x' . $value)->toHexUInt128();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt32($value))->toHexUInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test32To256()
    {
        $value = '12345678';
        $expected = '0000000000000000000000000000000000000000000000000000000012345678';

        $actual = HexUInt::fromHexUInt32($value)->toHexUInt256();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt32('0x' . $value)->toHexUInt256();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt32($value))->toHexUInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'ffffffff';
        $expected = '4294967295';

        $actual = HexUInt::fromHexUInt32($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt32($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }
}
