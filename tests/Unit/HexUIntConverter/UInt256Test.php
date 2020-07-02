<?php

namespace Tests\Unit\HexUIntConverter;

use Enjin\BlockchainTools\HexIntConverter\UInt256;
use Enjin\BlockchainTools\HexUIntConverter;
use Tests\TestCase;

class UInt256Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1234567890abcdef1234567890abcde';
        $value = str_pad($value, 63, 0);
        $expectedMessage = 'UInt256 value provided is invalid. Expected 64 characters but has: 63 (input value: 1234567890abcdef1234567890abcde00000000000000000000000000000000)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt256($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new UInt256($value);
        });

        $value = '1234567890abcdef1234567890abcdef1';
        $value = str_pad($value, 65, '0');
        $expectedMessage = 'UInt256 value provided is invalid. Expected 64 characters but has: 65 (input value: 1234567890abcdef1234567890abcdef100000000000000000000000000000000)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt256($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new UInt256($value);
        });
    }

    public function test256To8Top()
    {
        $value = str_pad('ab', 64, '0', STR_PAD_RIGHT);
        $expected = '0xab';

        $actual = HexUIntConverter::fromUInt256($value)->toUInt8Top();
        $this->assertEquals($expected, $actual);

        $actual = (new UInt256($value))->toUInt8Top();
        $this->assertEquals($expected, $actual);
    }

    public function test256To8Bottom()
    {
        $value = str_pad('ef', 64, '0', STR_PAD_LEFT);
        $expected = '0xef';

        $actual = HexUIntConverter::fromUInt256($value)->toUInt8Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new UInt256($value))->toUInt8Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test256To16Top()
    {
        $value = str_pad('1234', 64, '0', STR_PAD_RIGHT);
        $expected = '0x1234';

        $actual = HexUIntConverter::fromUInt256($value)->toUInt16Top();
        $this->assertEquals($expected, $actual);

        $actual = (new UInt256($value))->toUInt16Top();
        $this->assertEquals($expected, $actual);
    }

    public function test256To16Bottom()
    {
        $value = str_pad('cdef', 64, '0', STR_PAD_LEFT);
        $expected = '0xcdef';

        $actual = HexUIntConverter::fromUInt256($value)->toUInt16Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new UInt256($value))->toUInt16Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test256To32Top()
    {
        $value = str_pad('12345678', 64, '0', STR_PAD_RIGHT);
        $expected = '0x12345678';

        $actual = HexUIntConverter::fromUInt256($value)->toUInt32Top();
        $this->assertEquals($expected, $actual);

        $actual = (new UInt256($value))->toUInt32Top();
        $this->assertEquals($expected, $actual);
    }

    public function test256To32Bottom()
    {
        $value = str_pad('90abcdef', 64, '0', STR_PAD_LEFT);
        $expected = '0x90abcdef';

        $actual = HexUIntConverter::fromUInt256($value)->toUInt32Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new UInt256($value))->toUInt32Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test256To64Top()
    {
        $value = str_pad('1234567812345678', 64, '0', STR_PAD_RIGHT);
        $expected = '0x1234567812345678';

        $actual = HexUIntConverter::fromUInt256($value)->toUInt64Top();
        $this->assertEquals($expected, $actual);

        $actual = (new UInt256($value))->toUInt64Top();
        $this->assertEquals($expected, $actual);
    }

    public function test256To64Bottom()
    {
        $value = str_pad('1234567890abcdef', 64, '0', STR_PAD_LEFT);
        $expected = '0x1234567890abcdef';

        $actual = HexUIntConverter::fromUInt256($value)->toUInt64Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new UInt256($value))->toUInt64Bottom();
        $this->assertEquals($expected, $actual);
    }
}
