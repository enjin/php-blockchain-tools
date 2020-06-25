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

        $this->assertEquals(true, HexConverter::hasPrefix('0x' . $str));
        $this->assertEquals(false, HexConverter::hasPrefix($str));
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
     * @covers \Enjin\BlockchainTools\HexConverter::encodeString
     * @covers \Enjin\BlockchainTools\HexConverter::encodeStringPrefixed
     */
    public function testEncodeString()
    {
        $str = 'lt6X6Nf6sCYX9Aw6JZIl2p4LnrPnaLdu5SuCJ65ex9qqGCLHAoceGlEVF1kgHPi2pvcl32teI2DfNNwe6';

        $expected = '6c743658364e663673435958394177364a5a496c3270344c6e72506e614c6475355375434a3635657839717147434c48416f6365476c455646316b67485069327076636c33327465493244664e4e77653600000000000000000000000000000000';

        $encoded = HexConverter::encodeString($str, 97);
        $this->assertEquals($expected, $encoded);
        $this->assertEquals('0x' . $expected, HexConverter::encodeStringPrefixed($str, 97));
    }

    /**
     * @covers \Enjin\BlockchainTools\HexConverter::encodeString
     * @covers \Enjin\BlockchainTools\HexConverter::decodeString
     */
    public function testEncodeAndDecodeString()
    {
        $str = 'lt6X6Nf6sCYX9Aw6JZIl2p4LnrPnaLdu5SuCJ65ex9qqGCLHAoceGlEVF1kgHPi2pvcl32teI2DfNNwe6';
        $encoded = HexConverter::encodeString($str);
        $this->assertEquals($str, HexConverter::decodeString($encoded));
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


        $uInt256 = '0173815810847426045236197493370151523';
        $encoded = HexConverter::uInt256ToHex($uInt256);
        $expected = '00000000000000000000000000000000002179c7f7582cd1493c26a8cafe6263';
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
        $uInt256 = '01738158108474260452361974933701515230734836882550540189496323730524147000283064';
        $expected = 'f02d2a04c330c8fb';

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
        $uInt256 = '01738158108474260452361974933701515230734836882550540189496323730524147000283064';
        $expected = '3493a50c59ff80fb8';

        $encoded = HexConverter::uint256To128AsHexBottom($uInt256);
        $this->assertEquals($expected, $encoded);

        $encoded = HexConverter::uint256To128AsHexBottomPrefixed($uInt256);
        $this->assertEquals('0x' . $expected, $encoded);
    }
}
