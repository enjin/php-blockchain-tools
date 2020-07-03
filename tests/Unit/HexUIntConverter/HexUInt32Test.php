<?php

namespace Tests\Unit\HexUIntConverter;

use Enjin\BlockchainTools\HexIntConverter\HexUInt32;
use Enjin\BlockchainTools\HexUIntConverter;
use Tests\TestCase;

class HexUInt32Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1234567';
        $expectedMessage = 'HexUInt32 value provided is invalid. Expected 8 characters but has: 7 (input value: 1234567)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt32($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt32($value);
        });

        $value = '123456789';
        $expectedMessage = 'HexUInt32 value provided is invalid. Expected 8 characters but has: 9 (input value: 123456789)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt32($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt32($value);
        });
    }

    public function test32To8Top()
    {
        $value = str_pad('12', 8, '0', STR_PAD_RIGHT);
        $expected = '0x12';

        $actual = HexUIntConverter::fromUInt32($value)->toUInt8Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt32($value))->toUInt8Top();
        $this->assertEquals($expected, $actual);
    }

    public function test32To8Bottom()
    {
        $value = str_pad('78', 8, '0', STR_PAD_LEFT);
        $expected = '0x78';

        $actual = HexUIntConverter::fromUInt32($value)->toUInt8Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt32($value))->toUInt8Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test32To16Top()
    {
        $value = str_pad('1234', 8, '0', STR_PAD_RIGHT);
        $expected = '0x1234';

        $actual = HexUIntConverter::fromUInt32($value)->toUInt16Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt32($value))->toUInt16Top();
        $this->assertEquals($expected, $actual);
    }

    public function test32To16Bottom()
    {
        $value = str_pad('5678', 8, '0', STR_PAD_LEFT);
        $expected = '0x5678';

        $actual = HexUIntConverter::fromUInt32($value)->toUInt16Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt32($value))->toUInt16Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test32To64()
    {
        $value = '12345678';
        $expected = '0x0000000012345678';

        $actual = HexUIntConverter::fromUInt32($value)->toUInt64();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt32($value))->toUInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test32To128()
    {
        $value = '12345678';
        $expected = '0x00000000000000000000000012345678';

        $actual = HexUIntConverter::fromUInt32($value)->toUInt128();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt32($value))->toUInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test32To256()
    {
        $value = '12345678';
        $expected = '0x0000000000000000000000000000000000000000000000000000000012345678';

        $actual = HexUIntConverter::fromUInt32($value)->toUInt256();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt32($value))->toUInt256();
        $this->assertEquals($expected, $actual);
    }
}
