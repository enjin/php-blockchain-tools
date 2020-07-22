<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder\BasicDecoder;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockEncoder\BasicEncoder;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt8;
use Tests\Support\HasContractTestHelpers;
use Tests\TestCase;

class ContractEventCustomSerializersTest extends TestCase
{
    use HasContractTestHelpers;

    public function testCustomContractInputSerializer()
    {
        $name = 'foo';
        $address = 'bar';
        $json = $this->functionJSON();
        $contract = new Contract($name, $address, $json, BasicDecoder::class, BasicEncoder::class);
        // $contract = new Contract($name, $address, $json);

        $this->assertContractEventInputSerialization($contract);
    }

    public function testCustomEventSerializer()
    {
        $name = 'foo';
        $address = 'bar';
        $json = $this->functionJSON();
        $contract = new Contract($name, $address, $json);

        $contract->registerEventInputSerializers('e', BasicDecoder::class);

        $this->assertContractEventInputSerialization($contract);
    }

    protected function assertContractEventInputSerialization(Contract $contract): void
    {
        $event = $contract->event('e');
        $expected = $this->expectedData();
        $serialized = $this->serializedDataBlock();

        $topics = $this->eventTopics($event->signatureTopic());

        $serializedString = implode('', $serialized);

        $encoded = $event->decodeInput($topics, $serializedString)->toArray();

        $this->assertEncodedEquals($expected, $encoded, 'correctly encoded input data');
    }

    protected function functionJSON(): array
    {
        return [
            [
                'name' => 'e',
                'type' => 'event',
                'inputs' => [
                    [
                        'name' => 'myString',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'myNumber',
                        'type' => 'uint256',
                        'indexed' => true,
                    ],
                    [
                        'name' => 'mySmallNumber',
                        'type' => 'uint8',
                        'indexed' => true,
                    ],
                ],
            ],
        ];
    }

    protected function expectedData(): array
    {
        return [
            'myString' => 'Hello%!',
            'myNumber' => HexUInt256::fromUInt(62224)->toHex(),
            'mySmallNumber' => HexUInt8::fromUInt(16)->toHexUInt256(),
        ];
    }

    protected function serializedDataBlock(): array
    {
        return [
            '0000000000000000000000000000000000000000000000000000000000000020',
            '0000000000000000000000000000000000000000000000000000000000000007',
            '48656c6c6f252100000000000000000000000000000000000000000000000000',
        ];
    }

    protected function eventTopics($topic): array
    {
        return [
            $topic,
            '000000000000000000000000000000000000000000000000000000000000f310',
            '0000000000000000000000000000000000000000000000000000000000000010',
        ];
    }
}
