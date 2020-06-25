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
    public function testIntToHex()
    {
        $int = 882514;
        $expected = 'd7752';

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
     * @covers \Enjin\BlockchainTools\HexConverter::hexToInt
     */
    public function testHexToInt()
    {
        $hex = 'd7752';
        $expected = 882514;

        $encoded = HexConverter::hexToInt($hex);
        $this->assertEquals($expected, $encoded);

        $encoded = HexConverter::hexToInt('0x' . $hex);
        $this->assertEquals($expected, $encoded);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::uInt256ToHex
     * @covers \Enjin\BlockchainTools\HexConverter::uInt256ToHexPrefixed
     */
    public function testUInt256ToHex()
    {
        $uInt256 = '01738158108474260452361974933701515230734836882550540189496323730524147000283064';
        $encoded = HexConverter::uInt256ToHex($uInt256);
        $expected = 'f02d2a04c330c8fb6de7ab9653b7b4b3fcd771cfddf6a67e3493a50c59ff80fb8';
        $this->assertEquals($expected, $encoded);

        $uInt256 = '038706080339854479600326417178207427887749730641288511036';
        $encoded = HexConverter::uInt256ToHex($uInt256);
        $expected = '000000000000000001941c3edf88aca7587e41aa684965927079ec5bd6963e3c';
        $this->assertEquals($expected, $encoded);

        $encoded = HexConverter::uInt256ToHexPrefixed($uInt256);
        $this->assertEquals('0x' . $expected, $encoded);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::uint256To128AsHexTop
     * @covers \Enjin\BlockchainTools\HexConverter::uint256To128AsHexTopPrefixed
     */
    public function testUint256To128AsHexTop()
    {
        $uInt256 = '081927672940934803029854760644693165040200904336594723727925923706809402054567';
        $expected = 'b5216b6bd7192d67';

        $encoded = HexConverter::uint256To128AsHexTop($uInt256);
        $this->assertEquals($expected, $encoded);

        $encoded = HexConverter::uint256To128AsHexTopPrefixed($uInt256);
        $this->assertEquals('0x' . $expected, $encoded);
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::uint256To128AsHexBottom
     * @covers \Enjin\BlockchainTools\HexConverter::uint256To128AsHexBottomPrefixed
     */
    public function testUint256To128AsHexBottom()
    {
        $uInt256 = '054148363319296431240571427963542866010049542420325057378565843002662371236805';
        $expected = '94721fe8044c9bc5';

        $encoded = HexConverter::uint256To128AsHexBottom($uInt256);
        $this->assertEquals($expected, $encoded);

        $encoded = HexConverter::uint256To128AsHexBottomPrefixed($uInt256);
        $this->assertEquals('0x' . $expected, $encoded);
    }
}