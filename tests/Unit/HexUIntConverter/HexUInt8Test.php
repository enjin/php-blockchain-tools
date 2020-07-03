<?php

namespace Tests\Unit\HexUIntConverter;

use Enjin\BlockchainTools\HexIntConverter\HexUInt8;
use Enjin\BlockchainTools\HexUIntConverter;
use Tests\TestCase;

class HexUInt8Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1';
        $expectedMessage = 'HexUInt8 value provided is invalid. Expected 2 characters but has: 1 (input value: 1)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt8($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt8($value);
        });

        $value = '123';
        $expectedMessage = 'HexUInt8 value provided is invalid. Expected 2 characters but has: 3 (input value: 123)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUIntConverter::fromUInt8($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt8($value);
        });
    }

    public function test8To16()
    {
        $value = 'ff';
        $expected = '0x00ff';

        $actual = HexUIntConverter::fromUInt8($value)->toUInt16();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt8($value))->toUInt16();
        $this->assertEquals($expected, $actual);
    }

    public function test8To32()
    {
        $value = 'ff';
        $expected = '0x000000ff';

        $actual = HexUIntConverter::fromUInt8($value)->toUInt32();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt8($value))->toUInt32();
        $this->assertEquals($expected, $actual);
    }

    public function test8To64()
    {
        $value = 'ff';
        $expected = '0x00000000000000ff';

        $actual = HexUIntConverter::fromUInt8($value)->toUInt64();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt8($value))->toUInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test8To128()
    {
        $value = 'ff';
        $expected = '0x000000000000000000000000000000ff';

        $actual = HexUIntConverter::fromUInt8($value)->toUInt128();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt8($value))->toUInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test8To256()
    {
        $value = 'ff';
        $expected = '0x00000000000000000000000000000000000000000000000000000000000000ff';

        $actual = HexUIntConverter::fromUInt8($value)->toUInt256();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt8($value))->toUInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'ff';
        $expected = '255';

        $actual = HexUIntConverter::fromUInt8($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt8($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }
}
