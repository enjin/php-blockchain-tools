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
     */
    public function testEncodeString()
    {
        $str = 'lt6X6Nf6sCYX9Aw6JZIl2p4LnrPnaLdu5SuCJ65ex9qqGCLHAoceGlEVF1kgHPi2pvcl32teI2DfNNwe6';

        $expected = '6c743658364e663673435958394177364a5a496c3270344c6e72506e614c6475355375434a3635657839717147434c48416f6365476c455646316b67485069327076636c33327465493244664e4e77653600000000000000000000000000000000';

        $encoded = HexConverter::encodeString($str, 97);
        $this->assertEquals($expected, $encoded);
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
}
