<?php

namespace Tests\Unit\HexUInt;

use Enjin\BlockchainTools\HexNumber\HexUInt;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt128;
use Tests\TestCase;

class HexUInt128Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1234567890abcdef1234567890abcde';
        $expectedMessage = 'HexUInt128 value provided is invalid. Expected 32 characters but has: 31 (input value: 1234567890abcdef1234567890abcde)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUInt::fromHexUInt128($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt128($value);
        });

        $value = '1234567890abcdef1234567890abcdef1';
        $expectedMessage = 'HexUInt128 value provided is invalid. Expected 32 characters but has: 33 (input value: 1234567890abcdef1234567890abcdef1)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUInt::fromHexUInt128($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt128($value);
        });
    }

    public function test128To8Top()
    {
        $value = str_pad('12', 32, '0', STR_PAD_RIGHT);
        $expected = '12';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt8Top();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt8Top();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt8Top();
        $this->assertEquals($expected, $actual);
    }

    public function test128To8Bottom()
    {
        $value = str_pad('ef', 32, '0', STR_PAD_LEFT);
        $expected = 'ef';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt8Bottom();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt8Bottom();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt8Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test128To16Top()
    {
        $value = str_pad('1234', 32, '0', STR_PAD_RIGHT);
        $expected = '1234';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt16Top();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt16Top();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt16Top();
        $this->assertEquals($expected, $actual);
    }

    public function test128To16Bottom()
    {
        $value = str_pad('cdef', 32, '0', STR_PAD_LEFT);
        $expected = 'cdef';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt16Bottom();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt16Bottom();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt16Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test128To32Top()
    {
        $value = str_pad('12345678', 32, '0', STR_PAD_RIGHT);
        $expected = '12345678';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt32Top();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt32Top();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt32Top();
        $this->assertEquals($expected, $actual);
    }

    public function test128To32Bottom()
    {
        $value = str_pad('90abcdef', 32, '0', STR_PAD_LEFT);
        $expected = '90abcdef';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt32Bottom();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt32Bottom();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt32Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test128To64Top()
    {
        $value = str_pad('1234567812345678', 32, '0', STR_PAD_RIGHT);
        $expected = '1234567812345678';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt64Top();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt64Top();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt64Top();
        $this->assertEquals($expected, $actual);
    }

    public function test128To64Bottom()
    {
        $value = str_pad('1234567890abcdef', 32, '0', STR_PAD_LEFT);
        $expected = '1234567890abcdef';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt64Bottom();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt64Bottom();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt64Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test128To256()
    {
        $value = '12345678123456781234567890abcdef';
        $expected = '0000000000000000000000000000000012345678123456781234567890abcdef';

        $actual = HexUInt::fromHexUInt128($value)->toHexUInt256();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt128('0x' . $value)->toHexUInt256();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt128($value))->toHexUInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'aaaaaaaabbbbbbbbaaaaaaaabbbbbbbb';
        $expected = '226854911285907519808637577856120765371';

        $actual = HexUInt::fromHexUInt128($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }
}
