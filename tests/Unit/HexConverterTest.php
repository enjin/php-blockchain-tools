<?php

namespace Tests\Unit;

use Enjin\BlockchainTools\HexConverter;
use Tests\TestCase;

class HexConverterTest extends TestCase
{
    /**
     * @covers \Enjin\BlockchainTools\HexConverter::hasPrefix
     */
    public function testStrHasPrefix()
    {
        $str = $this->faker()->regexify('[A-Za-z0-9]{20}');

        $this->assertTrue(HexConverter::hasPrefix('0x' . $str));
        $this->assertFalse(HexConverter::hasPrefix($str));
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::prefix
     */
    public function testPrefix()
    {
        $str = $this->faker()->regexify('[A-Za-z0-9]{20}');

        $expected = '0x' . $str;
        $this->assertEquals($expected, HexConverter::prefix($str));
        $this->assertEquals($expected, HexConverter::prefix('0x' . $str));
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::unPrefix
     */
    public function testUnPrefix()
    {
        $str = $this->faker()->regexify('[A-Za-z0-9]{20}');

        $expected = $str;
        $this->assertEquals($expected, HexConverter::unPrefix($str));
        $this->assertEquals($expected, HexConverter::unPrefix('0x' . $str));
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::stringToHex
     * @covers \Enjin\BlockchainTools\HexConverter::stringToHexPrefixed
     */
    public function testStringToHex()
    {
        $str = 'lt6X6Nf6sCYX9Aw6JZIl2p4LnrPnaLdu5SuCJ65ex9qqGCLHAoceGlEVF1kgHPi2pvcl32teI2DfNNwe6';

        $expected = '6c743658364e663673435958394177364a5a496c3270344c6e72506e614c6475355375434a3635657839717147434c48416f6365476c455646316b67485069327076636c33327465493244664e4e77653600000000000000000000000000000000';

        $encoded = HexConverter::stringToHex($str, 97);
        $this->assertEquals($expected, $encoded);
        $this->assertEquals('0x' . $expected, HexConverter::stringToHexPrefixed($str, 97));
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::hexToString
     */
    public function testHexToString()
    {
        $hex = '746573745f737472696e67';
        $expected = 'test_string';
        $str = HexConverter::hexToString($hex);
        $this->assertEquals($expected, $str);

        $str = HexConverter::hexToString('0x' . $hex);
        $this->assertEquals($expected, $str);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::stringToHex
     * @covers \Enjin\BlockchainTools\HexConverter::hexToString
     */
    public function testStringToHexAndHexToString()
    {
        $str = 'lt6X6Nf6sCYX9Aw6JZIl2p4LnrPnaLdu5SuCJ65ex9qqGCLHAoceGlEVF1kgHPi2pvcl32teI2DfNNwe6';
        $encoded = HexConverter::stringToHex($str);
        $this->assertEquals($str, HexConverter::hexToString($encoded));
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::intToHex
     * @covers \Enjin\BlockchainTools\HexConverter::intToHexPrefixed
     */
    public function testIntToHexInt()
    {
        $int = 882514;
        $expected = '0d7752';

        $hex = HexConverter::intToHex($int);
        $this->assertEquals($expected, $hex);
        $this->assertEquals('0x' . $expected, HexConverter::intToHexPrefixed($int));

        $expected = '00000000000d7752';
        $hex = HexConverter::intToHex($int, 16);
        $this->assertEquals($expected, $hex);

        $hex = HexConverter::intToHexPrefixed($int, 16);
        $this->assertEquals('0x' . $expected, $hex);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::intToHex
     * @covers \Enjin\BlockchainTools\HexConverter::intToHexPrefixed
     */
    public function testNegativeIntToHexInt()
    {
        $int = -882514;
        $expected = 'f288ae';

        $hex = HexConverter::intToHex($int);
        $this->assertEquals($expected, $hex);
        $this->assertEquals('0x' . $expected, HexConverter::intToHexPrefixed($int));

        $expected = 'fffffffffff288ae';
        $hex = HexConverter::intToHex($int, 16);
        $this->assertEquals($expected, $hex);

        $hex = HexConverter::intToHexPrefixed($int, 16);
        $this->assertEquals('0x' . $expected, $hex);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::hexToInt
     */
    public function testHexIntToInt()
    {
        $hex = '000D7752';
        $expected = 882514;

        $int = HexConverter::hexToInt($hex);
        $this->assertEquals($expected, $int);

        $int = HexConverter::hexToInt('0x' . $hex);
        $this->assertEquals($expected, $int);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::hexToInt
     */
    public function testNegativeHexIntToInt()
    {
        $hex = 'fff288ae';
        $expected = -882514;

        $int = HexConverter::hexToInt($hex);
        $this->assertEquals($expected, $int);

        $int = HexConverter::hexToInt('0x' . $hex);
        $this->assertEquals($expected, $int);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::uintToHex
     * @covers \Enjin\BlockchainTools\HexConverter::uintToHexPrefixed
     */
    public function testUIntToHex()
    {
        $int = 882514;
        $expected = '0d7752';

        $hex = HexConverter::uintToHex($int);
        $this->assertEquals($expected, $hex);
        $this->assertEquals('0x' . $expected, HexConverter::uintToHexPrefixed($int));

        $expected = '00000000000d7752';
        $hex = HexConverter::uintToHex($int, 16);
        $this->assertEquals($expected, $hex);

        $hex = HexConverter::uintToHexPrefixed($int, 16);
        $this->assertEquals('0x' . $expected, $hex);

        $actual = HexConverter::hexToUInt($hex);
        $this->assertEquals($int, $actual);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::hexToUInt
     */
    public function testHexToIntZero()
    {
        $hex = '0';
        $expected = 0;

        $int = HexConverter::hexToUInt($hex);
        $this->assertEquals($expected, $int);

        $int = HexConverter::hexToUInt('0x' . $hex);
        $this->assertEquals($expected, $int);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::hexToUInt
     */
    public function testHexToInt()
    {
        $hex = 'd7752';
        $expected = 882514;

        $int = HexConverter::hexToUInt($hex);
        $this->assertEquals($expected, $int);

        $int = HexConverter::hexToUInt('0x' . $hex);
        $this->assertEquals($expected, $int);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::bytesToHex
     * @covers \Enjin\BlockchainTools\HexConverter::hexToBytes
     * @covers \Enjin\BlockchainTools\HexConverter::bytesToHexPrefixed
     */
    public function testHexToBytes()
    {
        $hex = 'd77522';
        $bytes = [
            215,
            117,
            34,
        ];

        $this->assertEquals($bytes, HexConverter::hexToBytes($hex));
        $this->assertEquals($hex, HexConverter::bytesToHex($bytes));
        $this->assertEquals('0x' . $hex, HexConverter::bytesToHexPrefixed($bytes));

        $hex = '1a2b3c4d5e6f';

        $bytes = [
            26,
            43,
            60,
            77,
            94,
            111,
        ];

        $this->assertEquals($bytes, HexConverter::hexToBytes($hex));
        $this->assertEquals($hex, HexConverter::bytesToHex($bytes));
        $this->assertEquals('0x' . $hex, HexConverter::bytesToHexPrefixed($bytes));
    }

    public function testHexToBytesZero()
    {
        $hex = '00';
        $bytes = [];

        $this->assertEquals($hex, HexConverter::bytesToHex($bytes));
        $this->assertEquals($bytes, HexConverter::hexToBytes($hex));
    }

    public function testBytesSymmetry()
    {
        $hex = '1a2b3c4d5e6f';

        $bytes = [
            26,
            43,
            60,
            77,
            94,
            111,
        ];

        $this->assertEquals($bytes, HexConverter::hexToBytes($hex));

        $this->assertEquals($hex, HexConverter::bytesToHex($bytes));
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::hexToBytes
     */
    public function testHexToBytesOddLength()
    {
        // Odd length hex should be padded with leading zero
        $this->assertEquals([1], HexConverter::hexToBytes('1'));
        $this->assertEquals([1], HexConverter::hexToBytes('0x1'));
        $this->assertEquals([1, 35], HexConverter::hexToBytes('123'));
        $this->assertEquals([1, 35], HexConverter::hexToBytes('0x123'));
        $this->assertEquals([13, 119, 82], HexConverter::hexToBytes('d7752'));
        $this->assertEquals([13, 119, 82], HexConverter::hexToBytes('0xd7752'));
    }
}
