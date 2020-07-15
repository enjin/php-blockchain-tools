<?php

namespace Tests\Unit\HexInt;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexInt;
use Enjin\BlockchainTools\HexNumber\HexInt\HexInt32;
use Tests\TestCase;

class HexInt32Test extends TestCase
{
    public function testInvalidLength()
    {
        $value = '1';
        $expectedMessage = 'HexInt32 value provided is invalid. Expected 8 characters but has: 1 (input value: 1)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexInt::fromHexInt32($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexInt32($value);
        });

        $value = '123';
        $expectedMessage = 'HexInt32 value provided is invalid. Expected 8 characters but has: 3 (input value: 123)';
        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            HexInt::fromHexInt32($value);
        });

        $this->assertInvalidArgumentException($expectedMessage, function () use ($value) {
            new HexInt32($value);
        });
    }

    public function test32To64()
    {
        $value = '1234561b';
        $expected = '000000001234561b';

        $actual = HexInt::fromHexInt32($value)->toHexInt64();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt32('0x' . $value)->toHexInt64();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt32($value))->toHexInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test32To64Negative()
    {
        $value = 'f234561b';
        $expected = 'fffffffff234561b';

        $actual = HexInt::fromHexInt32($value)->toHexInt64();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt32('0x' . $value)->toHexInt64();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt32($value))->toHexInt64();
        $this->assertEquals($expected, $actual);
    }

    public function test32To128()
    {
        $value = '1234562c';
        $expected = '0000000000000000000000001234562c';

        $actual = HexInt::fromHexInt32($value)->toHexInt128();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt32('0x' . $value)->toHexInt128();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt32($value))->toHexInt128();
        $this->assertEquals($expected, $actual);
    }

    public function test32To256()
    {
        $value = '1234564f';
        $expected = '000000000000000000000000000000000000000000000000000000001234564f';

        $actual = HexInt::fromHexInt32($value)->toHexInt256();
        $this->assertEquals($expected, $actual);

        $actual = HexInt::fromHexInt32('0x' . $value)->toHexInt256();
        $this->assertEquals('0x' . $expected, $actual);

        $actual = (new HexInt32($value))->toHexInt256();
        $this->assertEquals($expected, $actual);
    }

    public function testToDecimal()
    {
        $value = 'ffffffff';
        $expected = '-1';

        $actual = HexInt::fromHexInt32($value)->toDecimal();
        $this->assertEquals($expected, $actual);

        $actual = (new HexInt32($value))->toDecimal();
        $this->assertEquals($expected, $actual);
    }

    public function testPadLeft()
    {
        $value = '1';
        $expected = '00000001';

        $actual = HexInt32::padLeft($value);
        $this->assertEquals($expected, $actual);
    }

    public function testPadLeftNegative()
    {
        $value = 'f';
        $expected = 'ffffffff';

        $actual = HexInt32::padLeft($value);
        $this->assertEquals($expected, $actual);
    }

    public function testPadRight()
    {
        $value = 'a';
        $expected = 'a0000000';

        $actual = HexInt32::padRight($value);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider Int32Provider
     */
    public function testInt32($hex, $int)
    {
        $message = 'HexInt32::fromInt($int)->toHex() convert int: ' . $int . ' into expected hex: ' . $hex;
        $this->assertEquals($hex, HexInt32::fromInt($int)->toHex(), $message);

        $message = 'HexInt32::fromHex($hex)->toDecimal() convert hex: ' . $hex . ' into expected int: ' . $int;
        $this->assertEquals($int, HexInt32::fromHex($hex)->toDecimal(), $message);

        $message = 'HexConverter::intToHex convert int: ' . $int . ' into expected hex: ' . $hex;
        $this->assertEquals($hex, HexConverter::intToHex($int, HexInt32::HEX_LENGTH), $message);

        $message = 'HexConverter::hexToInt convert hex: ' . $hex . ' into expected int: ' . $int;
        $this->assertEquals($int, HexConverter::hexToInt($hex), $message);
    }

    public function Int32Provider()
    {
        return [
            [
                'hex' => HexInt32::HEX_MIN,
                'int' => HexInt32::INT_MIN,
            ],
            [
                'hex' => HexInt32::HEX_MAX,
                'int' => HexInt32::INT_MAX,
            ],
            [
                'hex' => '00000001',
                'int' => '1',
            ],
            [
                'hex' => '0000000a',
                'int' => '10',
            ],
            [
                'hex' => 'ffffffff',
                'int' => '-1',
            ],
            [
                'hex' => 'fffffff0',
                'int' => '-16',
            ],
            [
                'hex' => 'ffffff80',
                'int' => '-128',
            ],
            [
                'hex' => '0000007f',
                'int' => '127',
            ],
        ];
    }
}
