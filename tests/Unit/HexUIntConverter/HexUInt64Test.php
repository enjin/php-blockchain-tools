<?php

namespace Tests\Unit\HexUIntConverter;

use Enjin\BlockchainTools\HexIntConverter\HexUInt64;
use Enjin\BlockchainTools\HexUIntConverter;
use Tests\TestCase;

class HexUInt64Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1234567890abcde';
        $expectedMessage = 'HexUInt64 value provided is invalid. Expected 16 characters but has: 15 (input value: 1234567890abcde)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt64($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt64($value);
        });

        $value = '1234567890abcdefa';
        $expectedMessage = 'HexUInt64 value provided is invalid. Expected 16 characters but has: 17 (input value: 1234567890abcdefa)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt64($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt64($value);
        });
    }

    public function test64To8Top()
    {
        $value = str_pad('12', 16, '0', STR_PAD_RIGHT);
        $expected = '0x12';

        $actual = HexUIntConverter::fromUInt64($value)->toUInt8Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toUInt8Top();
        $this->assertEquals($expected, $actual);
    }

    public function test64To8Bottom()
    {
        $value = str_pad('ef', 16, '0', STR_PAD_LEFT);
        $expected = '0xef';

        $actual = HexUIntConverter::fromUInt64($value)->toUInt8Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toUInt8Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test64To16Top()
    {
        $value = str_pad('1234', 16, '0', STR_PAD_RIGHT);
        $expected = '0x1234';

        $actual = HexUIntConverter::fromUInt64($value)->toUInt16Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toUInt16Top();
        $this->assertEquals($expected, $actual);
    }

    public function test64To16Bottom()
    {
        $value = str_pad('cdef', 16, '0', STR_PAD_LEFT);
        $expected = '0xcdef';

        $actual = HexUIntConverter::fromUInt64($value)->toUInt16Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toUInt16Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test64To32Top()
    {
        $value = str_pad('12345678', 16, '0', STR_PAD_RIGHT);
        $expected = '0x12345678';

        $actual = HexUIntConverter::fromUInt64($value)->toUInt32Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toUInt32Top();
        $this->assertEquals($expected, $actual);
    }

    public function test64To32Bottom()
    {
        $value = str_pad('12abcdef', 16, '0', STR_PAD_LEFT);
        $expected = '0x12abcdef';

        $actual = HexUIntConverter::fromUInt64($value)->toUInt32Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toUInt32Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test64To128()
    {
        $value = '1234567812abcdef';
        $expected = '0x00000000000000001234567812abcdef';

        $actual = HexUIntConverter::fromUInt64($value)->toUInt128();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toUInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test64To256()
    {
        $value = '1234567812abcdef';
        $expected = '0x0000000000000000000000000000000000000000000000001234567812abcdef';

        $actual = HexUIntConverter::fromUInt64($value)->toUInt256();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toUInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'aaaaaaaabbbbbbbb';
        $expected = '12297829382759365563';

        $actual = HexUIntConverter::fromUInt64($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt64($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }
}
