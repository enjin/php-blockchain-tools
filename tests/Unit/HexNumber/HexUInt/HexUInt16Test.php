<?php

namespace Tests\Unit\HexUInt;

use Enjin\BlockchainTools\HexNumber\HexUInt;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt16;
use Tests\TestCase;

class HexUInt16Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '123';
        $expectedMessage = 'HexUInt16 value provided is invalid. Expected 4 characters but has: 3 (input value: 123)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUInt::fromHexUInt16($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt16($value);
        });

        $value = '12345';
        $expectedMessage = 'HexUInt16 value provided is invalid. Expected 4 characters but has: 5 (input value: 12345)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexUInt::fromHexUInt16($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexUInt16($value);
        });
    }

    public function test16To8Top()
    {
        $value = str_pad('12', 4, '0', STR_PAD_RIGHT);
        $expected = '12';

        $actual = HexUInt::fromHexUInt16($value)->toHexUInt8Top();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt16('0x' . $value)->toHexUInt8Top();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt16($value))->toHexUInt8Top();
        $this->assertEquals($expected, $actual);
    }

    public function test16To8Bottom()
    {
        $value = str_pad('34', 4, '0', STR_PAD_LEFT);
        $expected = '34';

        $actual = HexUInt::fromHexUInt16($value)->toHexUInt8Bottom();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt16('0x' . $value)->toHexUInt8Bottom();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt16($value))->toHexUInt8Bottom();
        $this->assertEquals($expected, $actual);
    }

    public function test16To32()
    {
        $value = '1234';
        $expected = '00001234';

        $actual = HexUInt::fromHexUInt16($value)->toHexUInt32();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt16('0x' . $value)->toHexUInt32();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt16($value))->toHexUInt32();
        $this->assertEquals($expected, $actual);
    }

    public function test16To64()
    {
        $value = '1234';
        $expected = '0000000000001234';

        $actual = HexUInt::fromHexUInt16($value)->toHexUInt64();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt16('0x' . $value)->toHexUInt64();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt16($value))->toHexUInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test16To128()
    {
        $value = '1234';
        $expected = '00000000000000000000000000001234';

        $actual = HexUInt::fromHexUInt16($value)->toHexUInt128();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt16('0x' . $value)->toHexUInt128();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt16($value))->toHexUInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test16To256()
    {
        $value = '1234';
        $expected = '0000000000000000000000000000000000000000000000000000000000001234';

        $actual = HexUInt::fromHexUInt16($value)->toHexUInt256();
        $this->assertEquals($expected, $actual);

        $actual = HexUInt::fromHexUInt16('0x' . $value)->toHexUInt256();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexUInt16($value))->toHexUInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'ffff';
        $expected = '65535';

        $actual = HexUInt::fromHexUInt16($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexUInt16($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }
}
