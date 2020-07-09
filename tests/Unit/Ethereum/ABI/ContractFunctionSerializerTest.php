<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\ContractFunctionSerializer;
use Enjin\BlockchainTools\HexConverter;
use Tests\TestCase;

class ContractFunctionSerializerTest extends TestCase
{
    public function testEncode()
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

        $expected = '0x9ef1e694';
        $this->assertEquals($expected, $function->methodId());

        $this->assertEquals($stateMutability, $function->stateMutability());

        $this->assertFalse($function->payable());
        $this->assertFalse($function->constant());

        $serializer = new ContractFunctionSerializer();

        $data = [
            '_from' => '41f502f01195652d3dc55a06f71d8d802ada241b',
            '_to' => '7d68cb169512d47ad39928b63bd97a40db65796d',
            '_ids' => [
                HexConverter::hexToUInt('0x700000000000160e000000000000000000000000000000000000000000000000'),
                HexConverter::hexToUInt('0x5000000000001008000000000000000000000000000000000000000000000000'),
            ],
            '_values' => [4, 4],
            '_data' => [],
        ];

        $encoded = $serializer->encode($function->inputs(), $data)->toArray();

        $expected = [
            '00000000000000000000000041f502f01195652d3dc55a06f71d8d802ada241b',
            '0000000000000000000000007d68cb169512d47ad39928b63bd97a40db65796d',
            '00000000000000000000000000000000000000000000000000000000000000a0',
            '0000000000000000000000000000000000000000000000000000000000000100',
            '0000000000000000000000000000000000000000000000000000000000000160',
            '0000000000000000000000000000000000000000000000000000000000000002',
            '700000000000160e000000000000000000000000000000000000000000000000',
            '5000000000001008000000000000000000000000000000000000000000000000',
            '0000000000000000000000000000000000000000000000000000000000000002',
            '0000000000000000000000000000000000000000000000000000000000000004',
            '0000000000000000000000000000000000000000000000000000000000000004',
            '0000000000000000000000000000000000000000000000000000000000000000',
            '0000000000000000000000000000000000000000000000000000000000000000',
        ];

        $this->assertEquals($expected, $encoded);

        $encodedData = implode('', $expected);
        $actual = $serializer->decode($function->inputs(), $encodedData);

        $this->assertEquals($data, $actual);
    }


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
            '251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df',
            '2124970518d797c13c878280e7b22d9c6d7ad12f8ec076fbe7012b6988ae3aa8',
            '42666c880cbd67e857257d51dad9daee33d72d8eadfe7d99613294802048329a',
            '643d5f1a56886692f5246f22c28201eace74755c53fe3870ab6fc7b67b8c5de0',
        ];

        $expected = [
            'tradeValues' => [
                '2555112959999467300',
                '53231519999999988452880',
                '10000',
                '1579686422033',
                '1204943999999749000',
                '565423',
                '0',
                '4655818029718533',
            ],
            'tradeAddresses' => [
                '0000000000000000000000000000000000000000',
                '037a54aab062628c9bbae1fdb1583c195585fe41',
                'f3cb44e421e1774affb4abbbe691962cea19fa11',
                '5ab9d116a53ef41063e3eae26a7ebe736720e9ba',
            ],
            'v' => [
                28,
                27,
            ],
            'rs' => [
                HexConverter::hexToBytes('251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df'),
                HexConverter::hexToBytes('2124970518d797c13c878280e7b22d9c6d7ad12f8ec076fbe7012b6988ae3aa8'),
                HexConverter::hexToBytes('42666c880cbd67e857257d51dad9daee33d72d8eadfe7d99613294802048329a'),
                HexConverter::hexToBytes('643d5f1a56886692f5246f22c28201eace74755c53fe3870ab6fc7b67b8c5de0'),
            ],
        ];

        $this->assertSerializer($function->inputs(), $expected, $serialized);
    }

    public function testCase2()
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
                ],
                'name' => 'setMeltFee',
                'outputs' => [
                ],
                'payable' => false,
                'stateMutability' => 'nonpayable',
                'type' => 'function',
            ],
        ];

        $contract = new Contract('foo', 'bar', $json);

        $function = $contract->function('setMeltFee');

        $expected = [
            '_id' => '36185027886661344501709775484676719393561338212044008423475592217920668696576',
            '_fee' => '500',
        ];

        $serialized = [
            '50000000000014ce000000000000000000000000000000000000000000000000',
            '00000000000000000000000000000000000000000000000000000000000001f4',
        ];
        $this->assertSerializer($function->inputs(), $expected, $serialized);
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

        $expected = [
            '_id' => '36185027886661344501709775484676719393561338212044008423475592217920668696576',
            '_values' => [1, 2, 3],
            '_to' => [
                '0xC814023915338E0FFA4a8f0Ba45C90Bf1d009a03',
                '0xC814023915338E0FFA4a8f0Ba45C90Bf1d009a03',
                '0xC814023915338E0FFA4a8f0Ba45C90Bf1d009a03',
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

        $expectedDecoded = $expected;
        $expectedDecoded['_to'] = array_map(function ($item) {
            return HexConverter::unPrefix($item);
        }, $expectedDecoded['_to']);

        $this->assertSerializer($function->inputs(), $expected, $serialized, $expectedDecoded);
    }

    protected function assertSerializer(
        array $functionValueTypes,
        array $data,
        array $serialized,
        array $expectedDecoded = []
    ) {
        $serializer = new ContractFunctionSerializer();

        $encoded = $serializer->encode($functionValueTypes, $data)->toArray();

        // dump($serializer->encode($functionValueTypes, $data)->toArrayWithMeta());
        //
        // $ex = array_map(function ($val) {
        //     return ltrim($val, '0') ?: '0';
        // }, $serialized);
        //
        // $en = array_map(function ($val) {
        //     return ltrim($val, '0') ?: '0';
        // }, $encoded);
        //
        // dump([
        //     'expected' => $ex,
        //     'encoded' => $en,
        // ]);


        $this->assertEquals($serialized, $encoded, 'correctly encoded data');

        $decoded = $serializer->decode($functionValueTypes, implode('', $serialized));
        $expectedDecoded = $expectedDecoded ?: $data;

        $this->assertEquals($expectedDecoded, $decoded, 'correctly decoded data');
    }
}
