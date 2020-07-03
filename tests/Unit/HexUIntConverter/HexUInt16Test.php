<?php

namespace Tests\Unit\HexUIntConverter;

use Enjin\BlockchainTools\HexIntConverter\HexUInt16;
use Enjin\BlockchainTools\HexUIntConverter;
use Tests\TestCase;

class HexUInt16Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '123';
        $expectedMessage = 'HexUInt16 value provided is invalid. Expected 4 characters but has: 3 (input value: 123)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt16($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt16($value);
        });

        $value = '12345';
        $expectedMessage = 'HexUInt16 value provided is invalid. Expected 4 characters but has: 5 (input value: 12345)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt16($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt16($value);
        });
    }

    public function test16To8Top()
    {
        $value = str_pad('12', 4, '0', STR_PAD_RIGHT);
        $expected = '0x12';

        $actual = HexUIntConverter::fromUInt16($value)->toUInt8Top();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt16($value))->toUInt8Top();
        $this->assertEquals($expected, $actual);
    }

    public function test16To8Bottom()
    {
        $value = str_pad('34', 4, '0', STR_PAD_LEFT);
        $expected = '0x34';

        $actual = HexUIntConverter::fromUInt16($value)->toUInt8Bottom();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt16($value))->toUInt8Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test16To32()
    {
        $value = '1234';
        $expected = '0x00001234';

        $actual = HexUIntConverter::fromUInt16($value)->toUInt32();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt16($value))->toUInt32();
        $this->assertEquals($expected, $actual);
    }

    public function test16To64()
    {
        $value = '1234';
        $expected = '0x0000000000001234';

        $actual = HexUIntConverter::fromUInt16($value)->toUInt64();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt16($value))->toUInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test16To128()
    {
        $value = '1234';
        $expected = '0x00000000000000000000000000001234';

        $actual = HexUIntConverter::fromUInt16($value)->toUInt128();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt16($value))->toUInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test16To256()
    {
        $value = '1234';
        $expected = '0x0000000000000000000000000000000000000000000000000000000000001234';

        $actual = HexUIntConverter::fromUInt16($value)->toUInt256();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt16($value))->toUInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'ffff';
        $expected = '65535';

        $actual = HexUIntConverter::fromUInt16($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt16($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }
}
