<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\ContractFunctionSerializer;
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
                        'name' => 'a',
                        'type' => 'uint',
                    ],
                    [
                        'name' => 'b',
                        'type' => 'uint32[]',
                    ],
                    [
                        'name' => 'c',
                        'type' => 'bytes10',
                    ],
                    [
                        'name' => 'd',
                        'type' => 'bytes',
                    ],
                ],
            ],
        ];
        $contract = new Contract($name, $address, $json);


        $function = $contract->function('f');

        $expected = 'f(uint,uint32[],bytes10,bytes)';
        $this->assertEquals($expected, $function->signature());

        $expected = '0x8be65246';
        $this->assertEquals($expected, $function->methodId());

        $this->assertEquals($stateMutability, $function->stateMutability());

        $this->assertEquals(false, $function->payable());
        $this->assertEquals(false, $function->constant());

        // $serializer = new ContractFunctionSerializer();
        //
        // $data = [
        //     'x' => 69,
        //     'y' => false,
        // ];
        //
        // $encoded = $serializer->encode($function, $data);
        dd($function);
    }
}
