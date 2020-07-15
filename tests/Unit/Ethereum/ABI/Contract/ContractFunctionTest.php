<?php

namespace Tests\Unit\Ethereum\ABI\Contract;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Tests\TestCase;

/**
 * @covers \Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction
 */
class ContractFunctionTest extends TestCase
{
    public function testInput()
    {
        $name = 'testFunction';
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
            ],
            'outputs' => [
                [
                    'name' => 'outputString',
                    'type' => 'string',
                ],
                [
                    'name' => 'outputNumber',
                    'type' => 'uint256',
                ],
            ],
            'name' => $name,
            'type' => 'function',
            'stateMutability' => 'view'
        ];

        $function = new Contract\ContractFunction($json);

        $this->assertEquals('testFunction(string,uint256,uint8)', $function->signature());
        $this->assertEquals('69564163', $function->methodId());
        // confirm cache coverage
        $this->assertEquals('69564163', $function->methodId());

        $this->assertEquals($name, $function->name());

        $this->assertCount(3, $function->inputs());

        $input1 = $function->input('myString');
        $input2 = $function->input('myNumber');
        $input3 = $function->input('mySmallNumber');

        $this->assertEquals($json['inputs'][0]['name'], $input1->name());
        $this->assertEquals($json['inputs'][0]['type'], $input1->type());

        $this->assertEquals($json['inputs'][1]['name'], $input2->name());
        $this->assertEquals($json['inputs'][1]['type'], $input2->type());

        $this->assertEquals($json['inputs'][2]['name'], $input3->name());
        $this->assertEquals($json['inputs'][2]['type'], $input3->type());

        $message = 'invalid input name: invalid-input-name for Contract Function: testFunction';
        $this->assertInvalidArgumentException($message, function () use ($function) {
            $function->input('invalid-input-name');
        });

        $this->assertCount(2, $function->outputs());


        $output1 = $function->output('outputString');
        $output2 = $function->output('outputNumber');

        $this->assertEquals($json['outputs'][0]['name'], $output1->name());
        $this->assertEquals($json['outputs'][0]['type'], $output1->type());

        $this->assertEquals($json['outputs'][1]['name'], $output2->name());
        $this->assertEquals($json['outputs'][1]['type'], $output2->type());

        $message = 'invalid output name: invalid-output-name for Contract Function: testFunction';
        $this->assertInvalidArgumentException($message, function () use ($function) {
            $function->output('invalid-output-name');
        });
    }
}
