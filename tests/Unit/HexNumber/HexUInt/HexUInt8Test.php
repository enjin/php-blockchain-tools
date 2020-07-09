<?php

namespace Tests\Unit\HexUInt;

use Enjin\BlockchainTools\HexNumber\HexUInt;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt8;
use Tests\TestCase;

class HexUInt8Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1';
        $expectedMessage = 'HexUInt8 value provided is invalid. Expected 2 characters but has: 1 (input value: 1)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUInt::fromHexUInt8($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt8($value);
        });

        $value = '123';
        $expectedMessage = 'HexUInt8 value provided is invalid. Expected 2 characters but has: 3 (input value: 123)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUInt::fromHexUInt8($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt8($value);
        });
    }

    public function test8To16()
    {
        $value = 'ff';
        $expected = '00ff';

        $actual = HexUInt::fromHexUInt8($value)->toHexUInt16();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt8('0x' . $value)->toHexUInt16();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt8($value))->toHexUInt16();
        $this->assertEquals($expected, $actual);
    }

    public function test8To32()
    {
        $value = 'ff';
        $expected = '000000ff';

        $actual = HexUInt::fromHexUInt8($value)->toHexUInt32();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt8('0x' . $value)->toHexUInt32();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt8($value))->toHexUInt32();
        $this->assertEquals($expected, $actual);
    }

    public function test8To64()
    {
        $value = 'ff';
        $expected = '00000000000000ff';

        $actual = HexUInt::fromHexUInt8($value)->toHexUInt64();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt8('0x' . $value)->toHexUInt64();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt8($value))->toHexUInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test8To128()
    {
        $value = 'ff';
        $expected = '000000000000000000000000000000ff';

        $actual = HexUInt::fromHexUInt8($value)->toHexUInt128();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt8('0x' . $value)->toHexUInt128();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt8($value))->toHexUInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test8To256()
    {
        $value = 'ff';
        $expected = '00000000000000000000000000000000000000000000000000000000000000ff';

        $actual = HexUInt::fromHexUInt8($value)->toHexUInt256();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt8('0x' . $value)->toHexUInt256();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt8($value))->toHexUInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'ff';
        $expected = '255';

        $actual = HexUInt::fromHexUInt8($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt8($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }

    public function testPadLeft()
    {
        $value = 'f';
        $expected = '0f';

        $actual = HexUInt8::padLeft($value);
        $this->assertEquals($expected, $actual);
    }

    public function testPadRight()
    {
        $value = 'a';
        $expected = 'a0';

        $actual = HexUInt8::padRight($value);
        $this->assertEquals($expected, $actual);
    }
}
