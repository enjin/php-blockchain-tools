<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder\BasicDecoder;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockEncoder\BasicEncoder;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;
use RuntimeException;
use Tests\Support\HasContractTestHelpers;
use Tests\TestCase;

class ContractFunctionCustomSerializersTest extends TestCase
{
    use HasContractTestHelpers;

    public function testCustomContractInputDefaultSerializer()
    {
        $name = 'foo';
        $address = 'bar';
        $json = $this->functionJSON();

        $serializers = [
            'functions' => [
                'f' => [
                    'decoder' => BasicDecoder::class,
                    'encoder' => BasicEncoder::class,
                ],
            ],
        ];

        $contract = new Contract($name, $address, $json, $serializers);

        $this->assertContractFunctionInputSerialization($contract);
    }

    public function testCustomContractOutputDefaultSerializer()
    {
        $name = 'foo';
        $address = 'bar';
        $json = $this->functionJSON();

        $json[0]['outputs'] = $json[0]['inputs'];
        unset($json[0]['inputs']);

        $serializers = [
            'functions' => [
                'f' => [
                    'decoder' => BasicDecoder::class,
                    'encoder' => BasicEncoder::class,
                ],
            ],
        ];

        $contract = new Contract($name, $address, $json, $serializers);

        $this->assertContractFunctionOutputSerialization($contract);
    }

    public function testCustomFunctionSerializer()
    {
        $name = 'foo';
        $address = 'bar';
        $json = $this->functionJSON();

        $serializers = [
            'functions' => [
                'f' => [
                    'input' => [
                        'decoder' => BasicDecoder::class,
                        'encoder' => BasicEncoder::class,
                    ],
                ],
            ],
        ];

        $contract = new Contract($name, $address, $json, $serializers);

        $this->assertContractFunctionInputSerialization($contract);
    }

    public function testCustomFunctionOutputSerializer()
    {
        $name = 'foo';
        $address = 'bar';
        $json = $this->functionJSON();

        $json[0]['outputs'] = $json[0]['inputs'];
        unset($json[0]['inputs']);

        $serializers = [
            'functions' => [
                'f' => [
                    'output' => [
                        'decoder' => BasicDecoder::class,
                        'encoder' => BasicEncoder::class,
                    ],
                ],
            ],
        ];

        $contract = new Contract($name, $address, $json, $serializers);

        $this->assertContractFunctionOutputSerialization($contract);
    }

    public function testEncodeEmptyBytes()
    {
        $json = [
            [
                'constant' => false,
                'inputs' => [
                    [
                        'name' => '_data',
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

        $serializers = [
            'decoder' => BasicDecoder::class,
            'encoder' => BasicEncoder::class,
        ];

        $contract = new Contract('foo', 'bar', $json, $serializers);

        $function = $contract->function('testFunction');

        $expected = [
            '_data' => [],
        ];

        $serialized = [
            '0000000000000000000000000000000000000000000000000000000000000020',
            '0000000000000000000000000000000000000000000000000000000000000000',
            '0000000000000000000000000000000000000000000000000000000000000000',
        ];

        $encoded = $function->encodeInput($expected)->toArray();

        $this->assertEncodedEquals($serialized, $encoded, 'correctly encoded input data');

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = $function->decodeInput($serializedString);

        $this->assertEquals($expected, $decoded->toArray(), 'correctly decoded input data');
    }

    public function testEncodeInvalid()
    {
        $json = [
            [
                'constant' => false,
                'inputs' => [
                    [
                        'name' => '_data',
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

        $serializers = [
            'decoder' => BasicDecoder::class,
            'encoder' => BasicEncoder::class,
        ];

        $contract = new Contract('foo', 'bar', $json, $serializers);

        $function = $contract->function('testFunction');

        $data = [
            '_data' => 'zxc',
        ];

        $expectedMessage = 'when attempting to encode: _data, caught InvalidArgumentException: array of bytes must be provided when encoding with this serializer, got object';
        $this->assertExceptionThrown(RuntimeException::class, $expectedMessage, function () use ($function, $data) {
            $function->encodeInput($data);
        });
    }

    protected function assertContractFunctionInputSerialization(Contract $contract): void
    {
        $function = $contract->function('f');
        $expected = $this->expectedData();
        $serialized = $this->serializedDataBlock();

        $encoded = $function->encodeInput($expected)->toArray();

        $this->assertEncodedEquals($serialized, $encoded, 'correctly encoded input data');

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = $function->decodeInput($serializedString);

        $this->assertEquals($expected, $decoded->toArray(), 'correctly decoded input data');
    }

    protected function assertContractFunctionOutputSerialization(Contract $contract): void
    {
        $function = $contract->function('f');
        $expected = $this->expectedData();
        $serialized = $this->serializedDataBlock();

        $encoded = $function->encodeOutput($expected)->toArray();

        $this->assertEncodedEquals($serialized, $encoded, 'correctly encoded output data');

        $serializedString = $function->methodId() . implode('', $serialized);
        $decoded = $function->decodeOutput($serializedString);

        $this->assertEquals($expected, $decoded->toArray(), 'correctly decoded output data');
    }

    protected function functionJSON(): array
    {
        return [
            [
                'name' => 'f',
                'type' => 'function',
                'stateMutability' => 'nonpayable',
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
                        'name' => '_flag',
                        'type' => 'bool',
                    ],
                    [
                        'name' => '_message',
                        'type' => 'string',
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
    }

    protected function expectedData(): array
    {
        $expected = [
            '_from' => '41f502f01195652d3dc55a06f71d8d802ada241b',
            '_to' => '7d68cb169512d47ad39928b63bd97a40db65796d',
            '_flag' => true,
            '_message' => 'this is a very long string big enough to take up more than one block of 64 bytes',
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

        return $expected;
    }

    protected function serializedDataBlock(): array
    {
        return [
            '00000000000000000000000041f502f01195652d3dc55a06f71d8d802ada241b',
            '0000000000000000000000007d68cb169512d47ad39928b63bd97a40db65796d',
            '0000000000000000000000000000000000000000000000000000000000000001',
            '00000000000000000000000000000000000000000000000000000000000000e0',
            '0000000000000000000000000000000000000000000000000000000000000160',
            '00000000000000000000000000000000000000000000000000000000000001c0',
            '0000000000000000000000000000000000000000000000000000000000000240',
            '0000000000000000000000000000000000000000000000000000000000000050',
            '7468697320697320612076657279206c6f6e6720737472696e67206269672065',
            '6e6f75676820746f2074616b65207570206d6f7265207468616e206f6e652062',
            '6c6f636b206f6620363420627974657300000000000000000000000000000000',
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
    }
}
