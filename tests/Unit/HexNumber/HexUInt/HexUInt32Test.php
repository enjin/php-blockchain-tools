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

    public function testConvertUpTo()
    {
        $message = 'Cannot convert up to 16 from 32. Can only convert up to larger bit sizes';
        $this->assertInvalidArgumentException($message, function () {
            $uint = new HexUInt32('ffffffff');
            $uint->convertUpTo(16);
        });
    }

    public function testConvertDownToTop()
    {
        $message = 'Cannot convert down to 128 from 32. Can only convert down to smaller bit sizes';
        $this->assertInvalidArgumentException($message, function () {
            $uint = new HexUInt32('ffffffff');
            $uint->convertDownToTop(128);
        });

        $uint = new HexUInt32('ffff0000');
        $converted = $uint->convertDownToTop(16);
        $this->assertEquals('ffff', $converted);

        $message = 'Cannot safely convert down to top of 16 from 32, non-zero bits would be lost. (0090) from end of (ffff0090)';
        $this->assertInvalidArgumentException($message, function () {
            $uint = new HexUInt32('ffff0090');
            $converted = $uint->convertDownToTop(16);
        });

        $uint = new HexUInt32('ffff0090');
        $converted = $uint->forceConvertDownToTop(16);
        $this->assertEquals('ffff', $converted);
    }

    public function testConvertDownToBottom()
    {
        $message = 'Cannot convert down to 128 from 32. Can only convert down to smaller bit sizes';
        $this->assertInvalidArgumentException($message, function () {
            $uint = new HexUInt32('ffffffff');
            $uint->convertDownToBottom(128);
        });

        $uint = new HexUInt32('0000abcd');
        $converted = $uint->convertDownToBottom(16);
        $this->assertEquals('abcd', $converted);

        $message = 'Cannot safely convert down to bottom of 16 from 32, non-zero bits would be lost. (0990) from start of (0990abcd)';
        $this->assertInvalidArgumentException($message, function () {
            $uint = new HexUInt32('0990abcd');
            $converted = $uint->convertDownToBottom(16);
        });

        $uint = new HexUInt32('0990abcd');
        $converted = $uint->forceConvertDownToBottom(16);
        $this->assertEquals('abcd', $converted);
    }

    public function testValidateIntRange()
    {
        $message = 'provided base 10 int(4294967296) is greater than max value for HexUInt32 (4294967295)';
        $this->assertInvalidArgumentException($message, function () {
            // one higher than max
            HexUInt32::fromUInt('4294967296');
        });

        $message = 'provided base 10 int(-1) is less than min value for HexUInt32 (0)';
        $this->assertInvalidArgumentException($message, function () {
            // one lower than min
            HexUInt32::fromUInt('-1');
        });
    }
}
