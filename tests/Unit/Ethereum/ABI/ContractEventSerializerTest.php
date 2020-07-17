<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\ContractEventSerializer;
use Enjin\BlockchainTools\HexConverter;
use Tests\TestCase;

class ContractEventSerializerTest extends TestCase
{
    public function testEventCase1()
    {
        $name = 'foo';
        $address = 'bar';

        $json = [
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
        $contract = new Contract($name, $address, $json);

        $topic = $contract->event('e')->signatureTopic();

        $expected = [
            'myString' => 'Hello%!',
            'myNumber' => '62224',
            'mySmallNumber' => 16,
        ];

        $topics = [
            $topic,
            '000000000000000000000000000000000000000000000000000000000000f310',
            '0000000000000000000000000000000000000000000000000000000000000010',
        ];

        $serialized = [
            '0000000000000000000000000000000000000000000000000000000000000020',
            '0000000000000000000000000000000000000000000000000000000000000007',
            '48656c6c6f252100000000000000000000000000000000000000000000000000',
        ];

        $event = $contract->findEventBySignatureTopic($topic);

        $data = '0x' . implode('', $serialized);
        $result = (new ContractEventSerializer())->decode($event->inputs(), $topics, $data);

        $this->assertEquals($expected, $result);
    }

    public function testIndexedEventInput()
    {
        $json = [
            [
                'inputs' => [
                    [
                        'name' => 'name',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'indexedName',
                        'type' => 'string',
                        'indexed' => true,
                    ],
                    [
                        'name' => 'id',
                        'type' => 'uint256',
                    ],
                    [
                        'name' => 'indexedId',
                        'type' => 'uint256',
                        'indexed' => true,
                    ],
                    [
                        'name' => 'data',
                        'type' => 'bytes',
                    ],
                    [
                        'name' => 'indexedData',
                        'type' => 'bytes',
                        'indexed' => true,
                    ],
                ],

                'name' => 'testEvent',
                'type' => 'event',
                'stateMutability' => 'view',
            ],
        ];

        $contract = new Contract('foo', 'bar', $json);

        $event = $contract->event('testEvent');

        $expected = [
            'name' => 'my name',
            'indexedName' => 'cannot decode topics with type: string',
            'id' => 88,
            'indexedId' => '32',
            'data' => HexConverter::hexToBytes('abcdef1234'),
            'indexedData' => 'cannot decode topics with type: bytes',
        ];

        $indexedIdHex = '0000000000000000000000000000000000000000000000000000000000000020';
        $topics = [
            $event->signatureTopic(),
            'would-be-kekak-encoded-string',
            $indexedIdHex,
            'would-be-kekak-encoded-bytes',
        ];

        $nameHex = '6d79206e616d6500000000000000000000000000000000000000000000000000';
        $idHex = '0000000000000000000000000000000000000000000000000000000000000058';
        $dataHex = 'abcdef1234000000000000000000000000000000000000000000000000000000';

        $serialized = [
            '0000000000000000000000000000000000000000000000000000000000000060',
            $idHex,
            '00000000000000000000000000000000000000000000000000000000000000a0',
            '0000000000000000000000000000000000000000000000000000000000000007',
            $nameHex,
            '0000000000000000000000000000000000000000000000000000000000000005',
            $dataHex,
        ];

        $serialized = '0x' . implode('', $serialized);
        $eventSerializer = new ContractEventSerializer();
        $result = $eventSerializer->decode($event->inputs(), $topics, $serialized);

        $this->assertEquals($expected, $result);

        $expectedRaw = [
            'name' => rtrim($nameHex, '0'),
            'indexedName' => 'cannot decode topics with type: string',
            'id' => $idHex,
            'indexedId' => $indexedIdHex,
            'data' => rtrim($dataHex, '0'),
            'indexedData' => 'cannot decode topics with type: bytes',
        ];

        $resultRaw = $eventSerializer->decodeRaw($event->inputs(), $topics, $serialized);

        $this->assertEquals($expectedRaw, $resultRaw);
    }
}
