<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder\BasicDecoder;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockEncoder\BasicEncoder;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;
use Tests\Support\HasContractTestHelpers;
use Tests\TestCase;

class ContractFunctionCustomSerializersTest extends TestCase
{
    use HasContractTestHelpers;

    public function testCustomerSerializerCase1()
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

        $contract->registerFunctionInputSerializers('f', BasicDecoder::class, BasicEncoder::class);

        $function = $contract->function('f');

        $expected = 'f(address,address,uint256[],uint256[],bytes)';
        $this->assertEquals($expected, $function->signature());

        $expected = '9ef1e694';
        $this->assertEquals($expected, $function->methodId());

        $this->assertEquals($stateMutability, $function->stateMutability());

        $this->assertFalse($function->payable());
        $this->assertFalse($function->constant());

        $expected = [
            '_from' => '41f502f01195652d3dc55a06f71d8d802ada241b',
            '_to' => '7d68cb169512d47ad39928b63bd97a40db65796d',
            '_ids' => [
                HexUInt256::HEX_MIN,
                HexUInt256::HEX_MAX,
            ],
            '_values' => [
                HexUInt256::fromUInt(7)->toHex(),
                HexUInt256::fromUInt(8)->toHex(),
                HexUInt256::fromUInt(9)->toHex(),
            ],
            '_data' => HexConverter::hexToBytes('251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df251b0de3886fb5597f493c6740717fbd64f7939eb5e3c0bec6a5ce924dca23df0bec6a5ce924dca23dfa'),
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

        $encoded = $function->encodeInput($expected)->toArray();

        // uncomment to get debug data
        // dump($serializer->encode($function->methodId(), $functionValueTypes, $data)->toArrayWithMeta());

        $this->assertEncodedEquals($serialized, $encoded, 'correctly encoded input data');

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = $function->decodeInput($serializedString);

        $this->assertEquals($expected, $decoded->toArray(), 'correctly decoded input data');
    }
}
