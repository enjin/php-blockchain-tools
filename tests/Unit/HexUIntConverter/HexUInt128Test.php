<?php

namespace Tests\Unit\HexUIntConverter;

use Enjin\BlockchainTools\HexIntConverter\HexUInt128;
use Enjin\BlockchainTools\HexIntConverter\HexUInt64;
use Enjin\BlockchainTools\HexUIntConverter;
use Tests\TestCase;

class HexUInt128Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1234567890abcdef1234567890abcde';
        $expectedMessage = 'HexUInt128 value provided is invalid. Expected 32 characters but has: 31 (input value: 1234567890abcdef1234567890abcde)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt128($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt128($value);
        });

        $value = '1234567890abcdef1234567890abcdef1';
        $expectedMessage = 'HexUInt128 value provided is invalid. Expected 32 characters but has: 33 (input value: 1234567890abcdef1234567890abcdef1)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt128($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt128($value);
        });
    }

    public function test128To8Top()
    {
        $value = str_pad('12', 32, '0', STR_PAD_RIGHT);
        $expected = '0x12';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt8Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt8Top();
        $this->assertEquals($expected, $actual);
    }

    public function test128To8Bottom()
    {
        $value = str_pad('ef', 32, '0', STR_PAD_LEFT);
        $expected = '0xef';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt8Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt8Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test128To16Top()
    {
        $value = str_pad('1234', 32, '0', STR_PAD_RIGHT);
        $expected = '0x1234';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt16Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt16Top();
        $this->assertEquals($expected, $actual);
    }

    public function test128To16Bottom()
    {
        $value = str_pad('cdef', 32, '0', STR_PAD_LEFT);
        $expected = '0xcdef';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt16Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt16Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test128To32Top()
    {
        $value = str_pad('12345678', 32, '0', STR_PAD_RIGHT);
        $expected = '0x12345678';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt32Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt32Top();
        $this->assertEquals($expected, $actual);
    }

    public function test128To32Bottom()
    {
        $value = str_pad('90abcdef', 32, '0', STR_PAD_LEFT);
        $expected = '0x90abcdef';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt32Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt32Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test128To64Top()
    {
        $value = str_pad('1234567812345678', 32, '0', STR_PAD_RIGHT);
        $expected = '0x1234567812345678';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt64Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt64Top();
        $this->assertEquals($expected, $actual);
    }

    public function test128To64Bottom()
    {
        $value = str_pad('1234567890abcdef', 32, '0', STR_PAD_LEFT);
        $expected = '0x1234567890abcdef';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt64Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt64Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test128To256()
    {
        $value = '12345678123456781234567890abcdef';
        $expected = '0x0000000000000000000000000000000012345678123456781234567890abcdef';

        $actual = HexUIntConverter::fromUInt128($value)->toUInt256();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toUInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'aaaaaaaabbbbbbbbaaaaaaaabbbbbbbb';
        $expected = '226854911285907519808637577856120765371';

        $actual = HexUIntConverter::fromUInt128($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt128($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }
}
