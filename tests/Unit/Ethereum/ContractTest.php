<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Tests\Support\HasContractTestHelpers;
use Tests\TestCase;

class ContractTest extends TestCase
{
    use HasContractTestHelpers;

    public function testCreate()
    {
        $name = $this->faker()->name;
        $address = $this->faker()->ethAddress;
        $json = [];

        $contract = new Contract($name, $address, $json);

        $this->assertEquals($name, $contract->name());
        $this->assertEquals($address, $contract->address());
    }

    public function testInvalidFunction()
    {
        $name = $this->faker()->name;
        $address = $this->faker()->ethAddress;
        $json = [];

        $contract = new Contract($name, $address, $json);

        $message = 'method name not found: invalid_function for Contract: ' . $name;
        $this->assertInvalidArgumentException($message, function () use ($contract) {
            $contract->function('invalid_function');
        });
    }

    public function testInvalidEvent()
    {
        $name = $this->faker()->name;
        $address = $this->faker()->ethAddress;
        $json = [];

        $contract = new Contract($name, $address, $json);

        $message = 'event name not found: invalid_event for Contract: ' . $name;
        $this->assertInvalidArgumentException($message, function () use ($contract) {
            $contract->event('invalid_event');
        });
    }

    public function testEvents()
    {
        $name = $this->faker()->name;
        $address = $this->faker()->ethAddress;

        $json = [
            $this->makeContractEventJson([
                $this->makeContractEventInputJson(),
                $this->makeContractEventInputJson(),
            ]),
            $this->makeContractEventJson([
                $this->makeContractEventInputJson(),
                $this->makeContractEventInputJson(),
            ]),
        ];

        $contract = new Contract($name, $address, $json);

        $this->assertCount(2, $contract->events());

        $this->assertContractEvent($contract->events()[0], $json[0]);
        $this->assertContractEvent($contract->events()[1], $json[1]);

        $this->assertContractEvent($contract->event($json[0]['name']), $json[0]);
        $this->assertContractEvent($contract->event($json[1]['name']), $json[1]);
    }

    public function testFunctions()
    {
        $name = $this->faker()->name;
        $address = $this->faker()->ethAddress;

        $json = [
            $this->makeContractFunctionJson([
                $this->makeContractFunctionInputJson(),
                $this->makeContractFunctionInputJson(),
            ]),
            $this->makeContractFunctionJson([
                $this->makeContractFunctionInputJson(),
                $this->makeContractFunctionInputJson(),
            ]),
        ];

        $contract = new Contract($name, $address, $json);

        $this->assertCount(2, $contract->functions());

        $this->assertContractFunction($contract->functions()[0], $json[0]);
        $this->assertContractFunction($contract->functions()[1], $json[1]);

        $this->assertContractFunction($contract->function($json[0]['name']), $json[0]);
        $this->assertContractFunction($contract->function($json[1]['name']), $json[1]);
    }

    public function testDecodeFunctionInput()
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
                'name' => 'setMeltFee',
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

        $data = $function->methodId() . implode('', $serialized);
        $decoded = $contract->decodeFunctionInput($data);

        $this->assertEquals($expected, $decoded);

        $decoded = $contract->decodeFunctionOutput($data);
        $this->assertEquals($expected, $decoded);
    }

    public function testDecodeFunctionInputNotFound()
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

        $message = 'function with matching methodId not found: invalidf';
        $this->assertInvalidArgumentException($message, function () use ($contract) {
            $contract->decodeFunctionInput('invalidf');
        });

        $this->assertInvalidArgumentException($message, function () use ($contract) {
            $contract->decodeFunctionOutput('invalidf');
        });
    }

    public function testDecodeEventInput()
    {
        $json = [
            [
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
                'name' => 'testEvent',
                'type' => 'event',
            ],
        ];

        $contract = new Contract('foo', 'bar', $json);

        $event = $contract->event('testEvent');

        $topic = $event->signatureTopic();

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

        $data = implode('', $serialized);
        $decoded = $contract->decodeEventInput($topics, $data);
        $this->assertEquals($expected, $decoded);
    }
}
