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

        $a = HexConverter::hexToUInt('0x123');
        $this->assertEquals(291, $a);

        $b1 = HexConverter::hexToUInt('0x456');
        $b2 = HexConverter::hexToUInt('0x789');

        $this->assertEquals(1110, $b1);
        $this->assertEquals(1929, $b2);

        $data = [
            '_from' => '0x41f502f01195652d3dc55a06f71d8d802ada241b',
            '_to' => '0x7d68cb169512d47ad39928b63bd97a40db65796d',
            '_ids' => [
                HexConverter::hexToUInt('0x700000000000160e000000000000000000000000000000000000000000000000'),
                HexConverter::hexToUInt('0x5000000000001008000000000000000000000000000000000000000000000000'),
            ],
            '_values' => [4, 4],
            '_data' => '',
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

        // dump($serializer->encode($function->inputs(), $data)->toArrayWithMeta());
        //
        // $ex = array_map(function ($val) {
        //     return ltrim($val, '0') ?: '0';
        // }, $expected);
        //
        // $en = array_map(function ($val) {
        //     return ltrim($val, '0') ?: '0';
        // }, $encoded);
        //
        // dump([
        //     'expected' => $ex,
        //     'encoded' => $en,
        // ]);

        $this->assertEquals($expected, $encoded);
    }
}
