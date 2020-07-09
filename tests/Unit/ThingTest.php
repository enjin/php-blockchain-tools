<?php

namespace Tests\Unit;

use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexInt\HexInt16;
use Enjin\BlockchainTools\HexInt\HexInt8;
use phpseclib\Math\BigInteger;
use Tests\TestCase;

class ThingTest extends TestCase
{
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

    /**
     * @dataProvider int16Provider
     */
    public function testInt16($hex, $int)
    {
        $this->assertEquals($hex, HexConverter::intToHexInt($int, HexInt16::LENGTH), 'convert int: ' . $int . ' into expected hex: ' . $hex);
        $this->assertEquals($int, HexConverter::hexIntToInt($hex, HexInt16::SIZE), 'convert hex: ' . $hex . ' into expected int: ' . $int);
    }

    public function int16Provider()
    {
        return [
            [
                'hex' => '0001',
                'int' => '1',
            ],
            [
                'hex' => '000a',
                'int' => '10',
            ],
            [
                'hex' => 'ffff',
                'int' => '-1',
            ],
            [
                'hex' => 'fff0',
                'int' => '-16',
            ],
            [
                'hex' => 'ff80',
                'int' => '-128',
            ],
            [
                'hex' => '007f',
                'int' => '127',
            ],
            [
                'hex' => '8000',
                'int' => '–32768',
            ],
            [
                'hex' => '7fff',
                'int' => '32767',
            ],
        ];
    }

    public function testThing()
    {
        $v = 'ff';

        $i = $this->hexdecs1($v);
        $this->assertEquals('-1', $i);

        $i = $this->hexdecs2($v);
        $this->assertEquals('-1', $i);

        // $i = HexConverter::hexIntToInt($v, HexInt8::INT_MAX);
        // dump($i);


    }

    protected function hexdecs2($hex)
    {
        // converted decimal value:
        $dec = hexdec($hex);

        $value = new BigInteger($hex, 16);
        $max = 256;
        $max = new BigInteger($max);

        $diff = $max->subtract($value);

        $valueGreaterThanDiff = $diff->compare($value) < 0;

        $inverted = null;
        if ($valueGreaterThanDiff) {
            $invert = new BigInteger('-1');
            $inverted = $diff->multiply($invert);
        }
        dump([
            'hexdecs2',

            'max' => $max,
            'value' => $value,
            'diff' => $diff,
            'valueGreaterThanDiff' => $valueGreaterThanDiff,
            'inverted' => $inverted,
        ]);

        if ($inverted) {
            return $inverted->toString();
        }
        return $value->toString();
    }

    protected function hexdecs1($hex)
    {
        // converted decimal value:
        $value = hexdec($hex);

        // maximum decimal value based on length of hex + 1:
        //   number of bits in hex number is 8 bits for each 2 hex -> max = 2^n
        //   use 'pow(2,n)' since '1 << n' is only for integers and therefore limited to integer size.
        $max = pow(2, 4 * (strlen($hex) + (strlen($hex) % 2)));

        // dd($max);
        // complement = maximum - converted hex:
        $diff = $max - $value;

        $inverted = null;
        $valueGreaterThanDiff = $value > $diff;
        if ($valueGreaterThanDiff) {
            $inverted = -$diff;
        }

        dump([
            'hexdecs1',

            'max' => $max,
            'value' => $value,
            'diff' => $diff,
            'valueGreaterThanDiff' => $valueGreaterThanDiff,
            'inverted' => $inverted,
        ]);

        if ($inverted) {
            return $inverted;
        }

        // if dec value is larger than its complement we have a negative value (first bit is set)
        return $value;
    }


    protected function hexdecs($hex)
    {
        // converted decimal value:
        $dec = hexdec($hex);

        // maximum decimal value based on length of hex + 1:
        //   number of bits in hex number is 8 bits for each 2 hex -> max = 2^n
        //   use 'pow(2,n)' since '1 << n' is only for integers and therefore limited to integer size.
        $max = pow(2, 4 * (strlen('ffff') + (strlen('ffff') % 2)));

        // dd($max);
        // complement = maximum - converted hex:
        $_dec = $max - $dec;

        // if dec value is larger than its complement we have a negative value (first bit is set)
        return $dec > $_dec ? -$_dec : $dec;
    }
}
