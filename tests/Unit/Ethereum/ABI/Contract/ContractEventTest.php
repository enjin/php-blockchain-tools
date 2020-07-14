<?php

namespace Tests\Unit\Ethereum\ABI\Contract;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Tests\TestCase;

/**
 * @covers \Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEvent
 */
class ContractEventTest extends TestCase
{
    public function testInput()
    {
        $name = 'testEvent';
        $json = [
            'inputs' => [
                [
                    'name' => 'myString',
                    'type' => 'string',
                ],
                [
                    'name' => 'myNumber',
                    'type' => 'uint256',
                ],
                [
                    'name' => 'mySmallNumber',
                    'type' => 'uint8',
                ],
                [
                    'name' => 'someBytes',
                    'type' => 'bytes',
                ]
            ],

            'name' => $name,
            'type' => 'event',
            'stateMutability' => 'view',
        ];

        $event = new Contract\ContractEvent($json);

        $this->assertEquals('testEvent(string,uint256,uint8,bytes)', $event->signature());

        $this->assertEquals('0x0a52aae0830ee31c3aae9537a0d0d25076e5b4580ac11460bd4617fb0345c3d8', $event->signatureTopic());
        // confirm cache coverage
        $this->assertEquals('0x0a52aae0830ee31c3aae9537a0d0d25076e5b4580ac11460bd4617fb0345c3d8', $event->signatureTopic());

        $this->assertEquals($name, $event->name());

        $this->assertCount(4, $event->inputs());

        $input1 = $event->input('myString');
        $input2 = $event->input('myNumber');
        $input3 = $event->input('mySmallNumber');
        $input4 = $event->input('someBytes');

        $this->assertEquals($json['inputs'][0]['name'], $input1->name());
        $this->assertEquals($json['inputs'][0]['type'], $input1->type());

        $this->assertEquals($json['inputs'][1]['name'], $input2->name());
        $this->assertEquals($json['inputs'][1]['type'], $input2->type());

        $this->assertEquals($json['inputs'][2]['name'], $input3->name());
        $this->assertEquals($json['inputs'][2]['type'], $input3->type());

        $this->assertEquals($json['inputs'][3]['name'], $input4->name());
        $this->assertEquals($json['inputs'][3]['type'], $input4->type());

        $message = 'invalid input name: invalid-input-name for Contract Event: testEvent';
        $this->assertInvalidArgumentException($message, function () use ($event) {
            $event->input('invalid-input-name');
        });
    }

    public function testIndexedTypes(){
        $name = 'testEvent';
        $json = [
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

            'name' => $name,
            'type' => 'event',
            'stateMutability' => 'view',
        ];

        $event = new Contract\ContractEvent($json);

        $this->assertEquals('testEvent(string,string,uint256,uint256,bytes,bytes)', $event->signature());

        $this->assertEquals('0x4581a5a0f5cfbb7d11c56a6cf6378ade3399f42dc3a846d5a0b438153d0f368a', $event->signatureTopic());
        // confirm cache coverage
        $this->assertEquals('0x4581a5a0f5cfbb7d11c56a6cf6378ade3399f42dc3a846d5a0b438153d0f368a', $event->signatureTopic());

    }
}
