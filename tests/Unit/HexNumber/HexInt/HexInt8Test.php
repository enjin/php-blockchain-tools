<?php

namespace Tests\Unit\HexInt;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexInt;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt8;
use Tests\TestCase;

class HexInt8Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1';
        $expectedMessage = 'HexInt8 value provided is invalid. Expected 2 characters but has: 1 (input value: 1)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexInt::fromHexInt8($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexInt8($value);
        });

        $value = '123';
        $expectedMessage = 'HexInt8 value provided is invalid. Expected 2 characters but has: 3 (input value: 123)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexInt::fromHexInt8($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexInt8($value);
        });
    }

    public function test8To16()
    {
        $value = '0a';
        $expected = '000a';

        $actual = HexInt::fromHexInt8($value)->toHexInt16();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt8('0x' . $value)->toHexInt16();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt8($value))->toHexInt16();
        $this->assertEquals($expected, $actual);
    }

    public function test8To16Negative()
    {
        $value = 'f6';
        $expected = 'fff6';

        $actual = HexInt::fromHexInt8($value)->toHexInt16();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt8('0x' . $value)->toHexInt16();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt8($value))->toHexInt16();
        $this->assertEquals($expected, $actual);
    }

    public function test8To32()
    {
        $value = 'ff';
        $expected = 'ffffffff';

        $actual = HexInt::fromHexInt8($value)->toHexInt32();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt8('0x' . $value)->toHexInt32();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt8($value))->toHexInt32();
        $this->assertEquals($expected, $actual);
    }

    public function test8To64()
    {
        $value = '1b';
        $expected = '000000000000001b';

        $actual = HexInt::fromHexInt8($value)->toHexInt64();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt8('0x' . $value)->toHexInt64();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt8($value))->toHexInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test8To128()
    {
        $value = '2c';
        $expected = '0000000000000000000000000000002c';

        $actual = HexInt::fromHexInt8($value)->toHexInt128();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt8('0x' . $value)->toHexInt128();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt8($value))->toHexInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test8To256()
    {
        $value = '4f';
        $expected = '000000000000000000000000000000000000000000000000000000000000004f';

        $actual = HexInt::fromHexInt8($value)->toHexInt256();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt8('0x' . $value)->toHexInt256();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt8($value))->toHexInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'ff';
        $expected = '-1';

        $actual = HexInt::fromHexInt8($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexInt8($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }

    public function testPadLeft()
    {
        $value = '1';
        $expected = '01';

        $actual = HexInt8::padLeft($value);
        $this->assertEquals($expected, $actual);
    }

    public function testPadLeftNegative()
    {
        $value = 'f';
        $expected = 'ff';

        $actual = HexInt8::padLeft($value);
        $this->assertEquals($expected, $actual);
    }

    public function testPadRight()
    {
        $value = 'a';
        $expected = 'a0';

        $actual = HexInt8::padRight($value, '0');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider int8Provider
     */
    public function testInt8($hex, $int)
    {
        $this->assertEquals($hex, HexConverter::intToHexInt($int, HexInt8::LENGTH), 'convert int: ' . $int . ' into expected hex: ' . $hex);
        $this->assertEquals($int, HexConverter::hexIntToInt($hex, HexInt8::SIZE), 'convert hex: ' . $hex . ' into expected int: ' . $int);
    }

    public function int8Provider()
    {
        return [
            [
                'hex' => '01',
                'int' => '1',
            ],
            [
                'hex' => '0a',
                'int' => '10',
            ],
            [
                'hex' => 'ff',
                'int' => '-1',
            ],
            [
                'hex' => 'f0',
                'int' => '-16',
            ],
            [
                'hex' => '80',
                'int' => '-128',
            ],
            [
                'hex' => '7f',
                'int' => '127',
            ],
        ];
    }

}
