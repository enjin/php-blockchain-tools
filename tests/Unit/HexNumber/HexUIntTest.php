<?php

namespace Tests\Unit\HexNumber;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt;
use Tests\TestCase;

class HexUIntTest extends TestCase
{
    public function testInvalidBitSize()
    {
        $this->assertInvalidArgumentException('Invalid bit size: 11', function () {
            HexUInt::fromHexUIntBitSize(11, 'ff')->toDecimal();
        });

        $this->assertInvalidArgumentException('Invalid bit size: 11', function () {
            HexUInt::fromUIntBitSize(11, '1')->toDecimal();
        });
    }

    public function testUInt()
    {
        foreach (HexUInt::BIT_SIZE_TO_CLASS as $bitSize => $class) {
            foreach ($this->makeTestCases($class) as $testCase) {
                $hex = $testCase['hex'];
                $int = $testCase['int'];
                $this->assertUIntClass($bitSize, $class, $hex, $int);
            }
        }
    }

    protected function assertUIntClass(int $bitSize, string $class, $hex, $int): void
    {
        $message = 'HexUInt::fromHexUInt' . $bitSize . '($hex)->toDecimal() convert hex: ' . $hex . ' into expected int: ' . $int;
        $method = 'fromHexUInt' . $bitSize;
        $this->assertEquals($int, HexUInt::{$method}($hex)->toDecimal(), $message);

        $message = 'HexUInt::fromHexUIntBitSize(' . $bitSize . ', $hex)->toDecimal() convert hex: ' . $hex . ' into expected int: ' . $int;
        $this->assertEquals($int, HexUInt::fromHexUIntBitSize($bitSize, $hex)->toDecimal(), $message);

        $message = 'HexInt::fromUIntBitSize(' . $bitSize . ', $int)->toDecimal() convert int: ' . $int . ' into expected int: ' . $int;
        $this->assertEquals($int, HexUInt::fromUIntBitSize($bitSize, $int)->toDecimal(), $message);

        $message = $class . '::fromInt($int)->toHex() convert int: ' . $int . ' into expected hex: ' . $hex;
        $this->assertEquals($hex, $class::fromUInt($int)->toHex(), $message);

        $message = $class . '::fromHex($hex)->toDecimal() convert hex: ' . $hex . ' into expected int: ' . $int;
        $this->assertEquals($int, $class::fromHex($hex)->toDecimal(), $message);

        $message = $class . '::fromHex($hex)->toUnPrefixed() convert hex: ' . $hex . ' into expected int: ' . $int;
        $this->assertEquals($hex, $class::fromHex($hex)->toUnPrefixed(), $message);

        $message = $class . '::fromHex($hex)->toPrefixed() convert hex: ' . $hex . ' into expected int: ' . $int;
        $this->assertEquals('0x' . $hex, $class::fromHex($hex)->toPrefixed(), $message);

        $message = 'HexConverter::intToHex convert int: ' . $int . ' into expected hex: ' . $hex;
        $this->assertEquals($hex, HexConverter::uintToHex($int, $class::HEX_LENGTH), $message);

        $message = 'HexConverter::hexToInt convert hex: ' . $hex . ' into expected int: ' . $int;
        $this->assertEquals($int, HexConverter::hexToUInt($hex), $message);
    }

    protected function makeTestCases($class)
    {
        return [
            [
                'hex' => $class::HEX_MIN,
                'int' => $class::INT_MIN,
            ],
            [
                'hex' => $class::HEX_MAX,
                'int' => $class::INT_MAX,
            ],
            [
                'hex' => str_pad('01', $class::HEX_LENGTH, '0', STR_PAD_LEFT),
                'int' => '1',
            ],
            [
                'hex' => str_pad('0a', $class::HEX_LENGTH, '0', STR_PAD_LEFT),
                'int' => '10',
            ],
            [
                'hex' => str_pad('7f', $class::HEX_LENGTH, '0', STR_PAD_LEFT),
                'int' => '127',
            ],
        ];
    }
}
