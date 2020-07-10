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
            'int8' => [
                'baseType' => 'int',
                'bitSize' => 8,
            ],
            'int16' => [
                'baseType' => 'int',
                'bitSize' => 16,
            ],
            'int32' => [
                'baseType' => 'int',
                'bitSize' => 32,
            ],
            'int64' => [
                'baseType' => 'int',
                'bitSize' => 64,
            ],
            'int128' => [
                'baseType' => 'int',
                'bitSize' => 128,
            ],
            'int256' => [
                'baseType' => 'int',
                'bitSize' => 256,
            ],
        ];

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
    }

    public function testParseUInt()
    {
        $cases = [
            // alias of int256
            'uint' => [
                'baseType' => 'uint',
                'bitSize' => 256,
            ],
            'uint8' => [
                'baseType' => 'uint',
                'bitSize' => 8,
            ],
            'uint16' => [
                'baseType' => 'uint',
                'bitSize' => 16,
            ],
            'uint32' => [
                'baseType' => 'uint',
                'bitSize' => 32,
            ],
            'uint64' => [
                'baseType' => 'uint',
                'bitSize' => 64,
            ],
            'uint128' => [
                'baseType' => 'uint',
                'bitSize' => 128,
            ],
            'uint256' => [
                'baseType' => 'uint',
                'bitSize' => 256,
            ],
        ];

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

        $this->assertDataTypeValues($type, $expected);
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
