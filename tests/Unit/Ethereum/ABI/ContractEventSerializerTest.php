<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\ContractEventSerializer;
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
}
