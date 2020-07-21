<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\ContractFunctionDecoder;
use Enjin\BlockchainTools\Ethereum\ABI\ContractFunctionEncoder;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt16;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;
use Tests\Support\HasContractTestHelpers;
use Tests\TestCase;

class ContractFunctionSerializationTest extends TestCase
{
    use HasContractTestHelpers;

    public function testCase1()
    {
        $name = 'foo';
        $address = 'bar';

        $stateMutability = 'nonpayable';

        $json = [
            [
                'name' => 'f',
                'type' => 'function',
                'stateMutability' => $stateMutability,
                'inputs' => [
                    [
                        'name' => '_from',
                        'type' => 'address',
                    ],
                    [
                        'name' => '_to',
                        'type' => 'address',
                    ],
                    [
                        'name' => '_ids',
                        'type' => 'uint256[]',
                    ],
                    [
                        'name' => '_values',
                        'type' => 'uint256[]',
                    ],
                    [
                        'name' => '_data',
                        'type' => 'bytes',
                    ],
                ],
            ],
        ];
        $contract = new Contract($name, $address, $json);

        $function = $contract->function('f');

        $expected = 'f(address,address,uint256[],uint256[],bytes)';
        $this->assertEquals($expected, $function->signature());

        $expected = '9ef1e694';
        $this->assertEquals($expected, $function->methodId());

        $this->assertEquals($stateMutability, $function->stateMutability());

        $this->assertFalse($function->payable());
        $this->assertFalse($function->constant());

        $expected = [
            '_from' => HexUInt256::padLeft('41f502f01195652d3dc55a06f71d8d802ada241b'),
            '_to' => HexUInt256::padLeft('7d68cb169512d47ad39928b63bd97a40db65796d'),
            '_ids' => [
                HexUInt256::HEX_MIN,
                HexUInt256::HEX_MAX,
            ],
            '_values' => [
                HexUInt256::fromUInt(7)->toHex(),
                HexUInt256::fromUInt(8)->toHex(),
                HexUInt256::fromUInt(9)->toHex(),
            ],
            '_data' => '251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df0bec6a5ce924dca23dfa',
        ];

        $serialized = [
            '00000000000000000000000041f502f01195652d3dc55a06f71d8d802ada241b',
            '0000000000000000000000007d68cb169512d47ad39928b63bd97a40db65796d',
            '00000000000000000000000000000000000000000000000000000000000000a0',
            '0000000000000000000000000000000000000000000000000000000000000100',
            '0000000000000000000000000000000000000000000000000000000000000180',
            '0000000000000000000000000000000000000000000000000000000000000002',
            HexUInt256::HEX_MIN,
            HexUInt256::HEX_MAX,
            '0000000000000000000000000000000000000000000000000000000000000003',
            '0000000000000000000000000000000000000000000000000000000000000007',
            '0000000000000000000000000000000000000000000000000000000000000008',
            '0000000000000000000000000000000000000000000000000000000000000009',
            '000000000000000000000000000000000000000000000000000000000000004a',
            '251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df',
            '251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df',
            '0bec6a5ce924dca23dfa00000000000000000000000000000000000000000000',
        ];
        $this->assertSerializerInput($function, $expected, $serialized);
    }

    public function testCase2()
    {
        $name = 'foo';
        $address = 'bar';

        $stateMutability = 'nonpayable';

        $json = [
            [
                'name' => 'f',
                'type' => 'function',
                'stateMutability' => $stateMutability,
                'inputs' => [
                    [
                        'name' => 'tradeValues',
                        'type' => 'uint256[8]',
                    ],
                    [
                        'name' => 'tradeAddresses',
                        'type' => 'address[4]',
                    ],
                    [
                        'name' => 'v',
                        'type' => 'uint8[2]',
                    ],
                    [
                        'name' => 'rs',
                        'type' => 'bytes32[4]',
                    ],
                ],
            ],
        ];
        $contract = new Contract($name, $address, $json);

        $function = $contract->function('f');

        $serializedBytes = [
            '251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df',
            '2124970518d797c13c878280e7b22d9c6d7ad12f8ec076fbe7012b6988ae3aa8',
            '42666c880cbd67e857257d51dad9daee33d72d8eadfe7d99613294802048329a',
            '643d5f1a56886692f5246f22c28201eace74755c53fe3870ab6fc7b67b8c5de0',
        ];

        $serialized = [
            '000000000000000000000000000000000000000000000000237595b315c3df24',
            '000000000000000000000000000000000000000000000b45afbd3f51d4dfce10',
            '0000000000000000000000000000000000000000000000000000000000002710',
            '0000000000000000000000000000000000000000000000000000016fcca5e611',
            '00000000000000000000000000000000000000000000000010b8d22f16392b88',
            '000000000000000000000000000000000000000000000000000000000008a0af',
            '0000000000000000000000000000000000000000000000000000000000000000',
            '00000000000000000000000000000000000000000000000000108a711bccdc05',
            '0000000000000000000000000000000000000000000000000000000000000000',
            '000000000000000000000000037a54aab062628c9bbae1fdb1583c195585fe41',
            '000000000000000000000000f3cb44e421e1774affb4abbbe691962cea19fa11',
            '0000000000000000000000005ab9d116a53ef41063e3eae26a7ebe736720e9ba',
            '000000000000000000000000000000000000000000000000000000000000001c',
            '000000000000000000000000000000000000000000000000000000000000001b',
            $serializedBytes[0],
            $serializedBytes[1],
            $serializedBytes[2],
            $serializedBytes[3],
        ];

        $expected = [
            'tradeValues' => [
                HexUInt256::fromUInt('2555112959999467300')->toHex(),
                HexUInt256::fromUInt('53231519999999988452880')->toHex(),
                HexUInt256::fromUInt('10000')->toHex(),
                HexUInt256::fromUInt('1579686422033')->toHex(),
                HexUInt256::fromUInt('1204943999999749000')->toHex(),
                HexUInt256::fromUInt('565423')->toHex(),
                HexUInt256::fromUInt('0')->toHex(),
                HexUInt256::fromUInt('4655818029718533')->toHex(),
            ],
            'tradeAddresses' => [
                HexUInt256::padLeft('0000000000000000000000000000000000000000'),
                HexUInt256::padLeft('037a54aab062628c9bbae1fdb1583c195585fe41'),
                HexUInt256::padLeft('f3cb44e421e1774affb4abbbe691962cea19fa11'),
                HexUInt256::padLeft('5ab9d116a53ef41063e3eae26a7ebe736720e9ba'),
            ],
            'v' => [
                HexUInt256::fromUInt(28)->toHex(),
                HexUInt256::fromUInt(27)->toHex(),
            ],
            'rs' => $serializedBytes,
        ];

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = $function->decodeInput($serializedString);

        $this->assertEquals($expected, $decoded->toArray(), 'correctly decodes');

        $encoded = $function->encodeInput($expected);

        $this->assertEquals($serialized, $encoded->toArray(), 'correctly encodes');
    }

    public function testCase3()
    {
        $json = [
            [
                'constant' => false,
                'inputs' => [
                    [
                        'name' => '_id',
                        'type' => 'uint256',
                    ],
                    [
                        'name' => '_fee',
                        'type' => 'uint16',
                    ],
                    [
                        'name' => '_flagged',
                        'type' => 'bool',
                    ],
                ],
                'name' => 'testFunction',
                'outputs' => [
                ],
                'payable' => false,
                'stateMutability' => 'nonpayable',
                'type' => 'function',
            ],
        ];

        $contract = new Contract('foo', 'bar', $json);

        $function = $contract->function('testFunction');

        $expected = [
            '_id' => HexUInt256::fromUInt('36185027886661344501709775484676719393561338212044008423475592217920668696576')->toHex(),
            '_fee' => HexUInt16::fromUInt('500')->toHexUInt256(),
            '_flagged' => HexUInt256::fromUInt('1')->toHex(),
        ];

        $serialized = [
            '50000000000014ce000000000000000000000000000000000000000000000000',
            '00000000000000000000000000000000000000000000000000000000000001f4',
            '0000000000000000000000000000000000000000000000000000000000000001',
        ];

        $this->assertSerializerInput($function, $expected, $serialized);
    }

    public function testCase4()
    {
        $json = [
            [
                'constant' => false,
                'inputs' => [
                    [
                        'name' => '_id',
                        'type' => 'uint256',
                    ],
                    [
                        'name' => '_to',
                        'type' => 'address[]',
                    ],
                    [
                        'name' => '_values',
                        'type' => 'uint256[]',
                    ],
                ],
                'name' => 'mintFungibles',
                'outputs' => [
                ],
                'payable' => false,
                'stateMutability' => 'nonpayable',
                'type' => 'function',
            ],
        ];

        $contract = new Contract('foo', 'bar', $json);

        $function = $contract->function('mintFungibles');

        $data = [
            '_id' => HexUInt256::fromUInt('36185027886661344501709775484676719393561338212044008423475592217920668696576')->toHex(),
            '_values' => [
                HexUInt256::fromUInt(1)->toHex(),
                HexUInt256::fromUInt(2)->toHex(),
                HexUInt256::fromUInt(3)->toHex(),
            ],
            '_to' => [
                HexUInt256::padLeft('C814023915338E0FFA4a8f0Ba45C90Bf1d009a03'),
                HexUInt256::padLeft('C814023915338E0FFA4a8f0Ba45C90Bf1d009a03'),
                HexUInt256::padLeft('C814023915338E0FFA4a8f0Ba45C90Bf1d009a03'),
            ],
        ];

        $serialized = [
            '50000000000014ce000000000000000000000000000000000000000000000000',
            '0000000000000000000000000000000000000000000000000000000000000060',
            '00000000000000000000000000000000000000000000000000000000000000e0',
            '0000000000000000000000000000000000000000000000000000000000000003',
            '000000000000000000000000C814023915338E0FFA4a8f0Ba45C90Bf1d009a03',
            '000000000000000000000000C814023915338E0FFA4a8f0Ba45C90Bf1d009a03',
            '000000000000000000000000C814023915338E0FFA4a8f0Ba45C90Bf1d009a03',
            '0000000000000000000000000000000000000000000000000000000000000003',
            '0000000000000000000000000000000000000000000000000000000000000001',
            '0000000000000000000000000000000000000000000000000000000000000002',
            '0000000000000000000000000000000000000000000000000000000000000003',
        ];

        $expectedDecoded = $data;
        $expectedDecoded['_to'] = array_map(function ($item) {
            return HexConverter::unPrefix($item);
        }, $expectedDecoded['_to']);

        $dataBlock = (new ContractFunctionEncoder())->encodeInput($function, $data);
        $this->assertEncodedEquals($serialized, $dataBlock->toArray(), 'correctly encoded input data');

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = (new ContractFunctionDecoder())->decodeInput($function, $serializedString);
        $this->assertEquals($expectedDecoded, $decoded->toArray(), 'correctly decoded input data');
    }

    public function testCase5()
    {
        $json = [
            [
                'constant' => false,
                'inputs' => [
                    [
                        'name' => 'name',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'numbers',
                        'type' => 'int16[]',
                    ],
                ],
                'name' => 'mintFungibles',
                'outputs' => [
                ],
                'payable' => false,
                'stateMutability' => 'nonpayable',
                'type' => 'function',
            ],
        ];

        $contract = new Contract('foo', 'bar', $json);

        $function = $contract->function('mintFungibles');

        $data = [
            'name' => HexConverter::stringToHex('Test Name Test Name this is a test and such so that it is long enough to cause a problem'),
            'numbers' => [
                HexUInt256::fromUInt(1)->toHex(),
                HexUInt256::fromUInt(2)->toHex(),
                HexUInt256::fromUInt(3)->toHex(),
                HexUInt256::fromUInt(4)->toHex(),
            ],
        ];

        $serialized = [
            '0000000000000000000000000000000000000000000000000000000000000040',
            '00000000000000000000000000000000000000000000000000000000000000c0',
            '0000000000000000000000000000000000000000000000000000000000000058',
            '54657374204e616d652054657374204e616d6520746869732069732061207465',
            '737420616e64207375636820736f2074686174206974206973206c6f6e672065',
            '6e6f75676820746f20636175736520612070726f626c656d0000000000000000',
            '0000000000000000000000000000000000000000000000000000000000000004',
            '0000000000000000000000000000000000000000000000000000000000000001',
            '0000000000000000000000000000000000000000000000000000000000000002',
            '0000000000000000000000000000000000000000000000000000000000000003',
            '0000000000000000000000000000000000000000000000000000000000000004',
        ];

        $dataBlock = (new ContractFunctionEncoder())->encodeInput($function, $data);
        $this->assertEncodedEquals($serialized, $dataBlock->toArray(), 'correctly encoded input data');

        // uncomment for debug data
        // dump($dataBlock->toArrayWithMeta());

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = (new ContractFunctionDecoder())->decodeInput($function, $serializedString);

        $this->assertEquals($data, $decoded->toArray(), 'correctly decoded input data');

        $this->assertEquals($function->methodId(), $dataBlock->methodId());
        $this->assertEquals($serializedString, $dataBlock->toString());
    }

    public function testEmptyStringAndBytes()
    {
        $json = [
            [
                'constant' => false,
                'inputs' => [
                    [
                        'name' => 'myString',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'myBytes',
                        'type' => 'bytes',
                    ],
                ],
                'name' => 'testFunction',
                'outputs' => [
                ],
                'payable' => false,
                'stateMutability' => 'nonpayable',
                'type' => 'function',
            ],
        ];

        $contract = new Contract('foo', 'bar', $json);

        $function = $contract->function('testFunction');

        $data = [
            'myString' => '',
            'myBytes' => '',
        ];

        $serialized = [
            '0000000000000000000000000000000000000000000000000000000000000040',
            '0000000000000000000000000000000000000000000000000000000000000060',
            '0000000000000000000000000000000000000000000000000000000000000000',
            '0000000000000000000000000000000000000000000000000000000000000000',
            '0000000000000000000000000000000000000000000000000000000000000000',
            '0000000000000000000000000000000000000000000000000000000000000000',
        ];

        $encoded = $function->encodeInput($data)->toArray();

        // uncomment to get debug data
        // dump($function->encodeInput($expected)->toArrayWithMeta());

        $this->assertEncodedEquals($serialized, $encoded, 'correctly encoded input data');

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = $function->decodeInput($serializedString);

        $expected = [
            'myString' => '',
            'myBytes' => '',
        ];

        $this->assertEquals($expected, $decoded->toArray(), 'correctly decoded input data');
    }

    public function testOutputCase1()
    {
        $json = [
            [
                'constant' => false,
                'inputs' => [
                    [
                        'name' => 'name',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'values',
                        'type' => 'uint16[]',
                    ],
                ],
                'name' => 'testOutputFunction',
                'outputs' => [
                    [
                        'name' => '_id',
                        'type' => 'uint256',
                    ],
                    [
                        'name' => '_fee',
                        'type' => 'uint16',
                    ],

                ],
                'payable' => false,
                'stateMutability' => 'nonpayable',
                'type' => 'function',
            ],
        ];

        $contract = new Contract('foo', 'bar', $json);

        $function = $contract->function('testOutputFunction');

        $data = [
            '_id' => HexUInt256::fromUInt('36185027886661344501709775484676719393561338212044008423475592217920668696576')->toHex(),
            '_fee' => HexUInt16::fromUInt('500')->toHexUInt256(),
        ];

        $serialized = [
            '50000000000014ce000000000000000000000000000000000000000000000000',
            '00000000000000000000000000000000000000000000000000000000000001f4',
        ];

        $this->assertSerializerOutput($function, $data, $serialized);

        $encoded = (new ContractFunctionEncoder())->encodeOutput($function, $data)->toArray();
        $this->assertEncodedEquals($serialized, $encoded, 'correctly encoded output data');

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = (new ContractFunctionDecoder())->decodeOutput($function, $serializedString);
        $this->assertEquals($data, $decoded->toArray(), 'correctly decoded output data');

        $encoded = $function->encodeOutput($data)->toArray();
        $this->assertEncodedEquals($serialized, $encoded, 'correctly encoded output data');

        $decoded = $function->decodeOutput($serializedString);
        $this->assertEquals($data, $decoded->toArray(), 'correctly decoded output data');
    }
}
