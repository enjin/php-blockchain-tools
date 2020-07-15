<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\DataTypeParser;
use Enjin\BlockchainTools\HexNumber\HexNumber;
use Tests\TestCase;

class DataTypeParserTest extends TestCase
{
    public function testParseInt()
    {
        $cases = [
            // alias of int256
            'int' => [
                'baseType' => 'int',
                'bitSize' => 256,
            ],
        ];

        foreach (HexNumber::VALID_BIT_SIZES as $size) {
            $cases['int' . $size] = [
                'baseType' => 'int',
                'bitSize' => $size,
            ];
        }

        foreach ($cases as $type => $expected) {
            $this->assertDataTypeValues($type, $expected);
        }

        foreach ($cases as $type => $expected) {
            $type .= '[]';
            $expected = array_merge($expected, [
                'arrayLength' => 'dynamic',
                'isArray' => true,
            ]);
            $this->assertDataTypeValues($type, $expected);
        }

        foreach ($cases as $type => $expected) {
            $length = random_int(1, 10);
            $type .= '[' . $length . ']';

            $expected = array_merge($expected, [
                'arrayLength' => $length,
                'isArray' => true,
            ]);
            $this->assertDataTypeValues($type, $expected);
        }

        $this->assertDataTypeValues($type, $expected);

        $message = 'invalid int bit size in type: int299';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('int299');
        });
    }

    public function testParseUInt()
    {
        $cases = [
            // alias of int256
            'uint' => [
                'baseType' => 'uint',
                'bitSize' => 256,
            ],
        ];

        foreach (HexNumber::VALID_BIT_SIZES as $size) {
            $cases['uint' . $size] = [
                'baseType' => 'uint',
                'bitSize' => $size,
            ];
        }

        foreach ($cases as $type => $expected) {
            $this->assertDataTypeValues($type, $expected);
        }

        foreach ($cases as $type => $expected) {
            $type .= '[]';
            $expected = array_merge($expected, [
                'arrayLength' => 'dynamic',
                'isArray' => true,
            ]);
            $this->assertDataTypeValues($type, $expected);
        }

        foreach ($cases as $type => $expected) {
            $length = random_int(1, 10);
            $type .= '[' . $length . ']';

            $expected = array_merge($expected, [
                'arrayLength' => $length,
                'isArray' => true,
            ]);
            $this->assertDataTypeValues($type, $expected);
        }

        $this->assertDataTypeValues($type, $expected);

        $message = 'invalid uint bit size in type: uint299';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('uint299');
        });
    }

    public function testParseBool()
    {
        $type = 'bool';
        $expected = [
            'rawType' => 'uint8',
            'baseType' => 'uint',
            'bitSize' => 8,
            'aliasedFrom' => 'bool',
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'bool[]';
        $expected = [
            'rawType' => 'uint8[]',
            'baseType' => 'uint',
            'bitSize' => 8,
            'isArray' => true,
            'arrayLength' => 'dynamic',
            'aliasedFrom' => $type,
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'bool[99]';
        $expected = [
            'rawType' => 'uint8[99]',
            'baseType' => 'uint',
            'bitSize' => 8,
            'isArray' => true,
            'arrayLength' => 99,
            'aliasedFrom' => $type,
        ];
    }

    public function testParseFunction()
    {
        $type = 'function';
        $expected = [
            'rawType' => 'bytes24',
            'baseType' => 'bytes',
            'bitSize' => 24,
            'isArray' => false,
            'aliasedFrom' => 'function',
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'function[]';
        $expected = [
            'rawType' => 'bytes24[]',
            'baseType' => 'bytes',
            'bitSize' => 24,
            'isArray' => true,
            'arrayLength' => 'dynamic',
            'aliasedFrom' => $type,
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'function[88]';
        $expected = [
            'rawType' => 'bytes24[88]',
            'baseType' => 'bytes',
            'bitSize' => 24,
            'isArray' => true,
            'arrayLength' => 88,
            'aliasedFrom' => $type,
        ];

        $this->assertDataTypeValues($type, $expected);
    }

    public function testParseAddress()
    {
        $type = 'address';
        $expected = [
            'rawType' => 'address',
            'baseType' => 'address',
            'bitSize' => 160,
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'address[]';
        $expected = [
            'rawType' => 'address[]',
            'baseType' => 'address',
            'bitSize' => 160,
            'isArray' => true,
            'arrayLength' => 'dynamic',
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'address[88]';
        $expected = [
            'rawType' => 'address[88]',
            'baseType' => 'address',
            'bitSize' => 160,
            'isArray' => true,
            'arrayLength' => 88,
        ];

        $this->assertDataTypeValues($type, $expected);
    }

    public function testParseString()
    {
        $type = 'string';
        $expected = [
            'baseType' => 'string',
            'bitSize' => 'dynamic',
            'isArray' => false,
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'string[]';
        $expected = [
            'rawType' => 'string[]',
            'baseType' => 'string',
            'bitSize' => 'dynamic',
            'isArray' => true,
            'arrayLength' => 'dynamic',
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'string[88]';
        $expected = [
            'rawType' => 'string[88]',
            'baseType' => 'string',
            'bitSize' => 'dynamic',
            'isArray' => true,
            'arrayLength' => 88,
        ];

        $this->assertDataTypeValues($type, $expected);
    }

    public function testParseBytes()
    {
        $type = 'bytes';
        $expected = [
            'baseType' => 'bytes',
            'bitSize' => 'dynamic',
            'isArray' => false,
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'bytes[]';
        $expected = [
            'rawType' => 'bytes[]',
            'baseType' => 'bytes',
            'bitSize' => 'dynamic',
            'isArray' => true,
            'arrayLength' => 'dynamic',
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'bytes[88]';
        $expected = [
            'rawType' => 'bytes[88]',
            'baseType' => 'bytes',
            'bitSize' => 'dynamic',
            'isArray' => true,
            'arrayLength' => 88,
        ];

        $this->assertDataTypeValues($type, $expected);

        foreach (range(1, 32) as $length) {
            $baseType = 'bytes' . $length;

            $type = $baseType;
            $expected = [
                'baseType' => 'bytes',
                'bitSize' => $length,
                'isArray' => false,
            ];

            $this->assertDataTypeValues($type, $expected);

            $type = $baseType . '[]';
            $expected = [
                'baseType' => 'bytes',
                'bitSize' => $length,
                'isArray' => true,
                'arrayLength' => 'dynamic',
            ];

            $this->assertDataTypeValues($type, $expected);

            $type = $baseType . '[55]';
            $expected = [
                'baseType' => 'bytes',
                'bitSize' => $length,
                'isArray' => true,
                'arrayLength' => 55,
            ];

            $this->assertDataTypeValues($type, $expected);
        }

        $message = 'invalid bytes bit size in type: bytes33';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('bytes33');
        });
    }

    public function testParseFixed()
    {
        $type = 'fixed';
        $expected = [
            'baseType' => 'fixed',
            'bitSize' => 128,
            'decimalPrecision' => 18,
            'isArray' => false,
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'fixed[]';
        $expected = [
            'rawType' => 'fixed[]',
            'baseType' => 'fixed',
            'bitSize' => 128,
            'decimalPrecision' => 18,
            'isArray' => true,
            'arrayLength' => 'dynamic',
        ];

        $this->assertDataTypeValues($type, $expected);

        $type = 'fixed[88]';
        $expected = [
            'rawType' => 'fixed[88]',
            'baseType' => 'fixed',
            'bitSize' => 128,
            'decimalPrecision' => 18,
            'isArray' => true,
            'arrayLength' => 88,
        ];

        $this->assertDataTypeValues($type, $expected);

        foreach (range(1, 80) as $decimalPrecision) {
            $bitSizes = HexNumber::VALID_BIT_SIZES;

            foreach ($bitSizes as $bitSize) {
                $baseType = 'fixed' . $bitSize . 'x' . $decimalPrecision;

                $type = $baseType;
                $expected = [
                    'baseType' => 'fixed',
                    'bitSize' => $bitSize,
                    'decimalPrecision' => $decimalPrecision,
                ];

                $this->assertDataTypeValues($type, $expected);

                $type = $baseType . '[]';
                $expected = [
                    'baseType' => 'fixed',
                    'bitSize' => $bitSize,
                    'isArray' => true,
                    'arrayLength' => 'dynamic',
                    'decimalPrecision' => $decimalPrecision,
                ];

                $this->assertDataTypeValues($type, $expected);

                $type = $baseType . '[55]';
                $expected = [
                    'baseType' => 'fixed',
                    'bitSize' => $bitSize,
                    'isArray' => true,
                    'arrayLength' => 55,
                    'decimalPrecision' => $decimalPrecision,
                ];

                $this->assertDataTypeValues($type, $expected);
            }
        }

        $message = 'invalid bit size: 1, in: fixed1x8';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('fixed1x8');
        });

        $message = 'invalid bit size: a, in: fixedax8';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('fixedax8');
        });

        $message = 'invalid decimal precision: 99, in: fixed16x99';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('fixed16x99');
        });

        $message = 'invalid decimal precision: a, in: fixed1xa';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('fixed1xa');
        });
    }

    public function testParseInvalid()
    {
        $message = 'Invalid type: invalid-type';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('invalid-type');
        });
    }

    public function testParseInvalidArrayLength()
    {
        $message = 'invalid array length in type: int[abc]';
        $this->assertInvalidArgumentException($message, function () {
            $parser = new DataTypeParser();
            $parser->parse('int[abc]');
        });
    }

    private function assertDataTypeValues(string $type, array $expected, string $message = '')
    {
        if ($message) {
            $message = ', ' . $message;
        }
        $message = 'case: ' . $type . $message;

        $defaults = [
            'rawType' => $type,
            'baseType' => null,
            'bitSize' => null,
            'arrayLength' => null,
            'isArray' => false,
            'aliasedFrom' => null,
            'decimalPrecision' => null,
        ];
        $expected = array_merge($defaults, $expected);

        $parser = new DataTypeParser();
        $dataType = $parser->parse($type);

        $actual = [
            'baseType' => $dataType->baseType(),
            'rawType' => $dataType->rawType(),
            'bitSize' => $dataType->bitSize(),
            'arrayLength' => $dataType->arrayLength(),
            'isArray' => $dataType->isArray(),
            'aliasedFrom' => $dataType->aliasedFrom(),
            'decimalPrecision' => $dataType->decimalPrecision(),
        ];
        $this->assertEquals($expected, $actual, $message);
    }
}
