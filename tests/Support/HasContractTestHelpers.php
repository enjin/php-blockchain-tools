<?php

namespace Tests\Support;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEvent;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEventInput;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunctionValueType;

trait HasContractTestHelpers
{
    private function makeContractFunctionJson(array $inputs = [], array $outputs = [])
    {
        return [
            'name' => $this->faker()->name,
            'type' => 'function',
            'stateMutability' => $this->faker()->randomElement(ContractFunction::VALID_MUTABILITY_VALUES),
            'payable' => $this->faker()->boolean,
            'constant' => $this->faker()->boolean,

            'inputs' => $inputs,
            'outputs' => $outputs,
        ];
    }

    private function assertContractFunction(ContractFunction $function, array $json, string $message = '')
    {
        $functionMessage = $message;
        if ($message) {
            $functionMessage = ', ' . $message;
        }
        $stateMutability = $json['stateMutability'];
        $payable = $stateMutability === 'payable';
        $constant = in_array($stateMutability, ['pure', 'view']);
        $this->assertEquals($json['name'], $function->name(), $functionMessage . 'assert contract function name');
        $this->assertEquals($stateMutability, $function->stateMutability(), $functionMessage . 'assert contract function stateMutability');
        $this->assertEquals($payable, $function->payable(), $functionMessage . 'assert contract function payable');

        $this->assertEquals($constant, $function->constant(), $functionMessage . 'assert contract function constant');

        if (array_key_exists('inputs', $json)) {
            $jsonInputsByName = [];

            foreach ($json['inputs'] as $inputJson) {
                $inputName = $inputJson['name'];
                $jsonInputsByName[$inputName] = $inputJson;
                $functionInput = $function->input($inputName);
                $this->assertContractFunctionInput($functionInput, $inputJson, $message);
            }

            foreach ($function->inputs() as $functionInput) {
                $inputJson = $jsonInputsByName[$functionInput->name()];
                $this->assertContractFunctionInput($functionInput, $inputJson, $message);
            }
        }
    }

    private function makeContractFunctionInputJson(array $data = []): array
    {
        return array_merge([
            'name' => $this->faker()->name,
            'type' => $this->randomValueType(),
            'components' => [],
        ], $data);
    }

    private function assertContractFunctionInput(ContractFunctionValueType $input, array $json, string $message = '')
    {
        if ($message) {
            $message = ', ' . $message;
        }
        $this->assertEquals($json['name'], $input->name(), $message . 'assert contract function input name');
        $this->assertEquals($json['type'], $input->type(), $message . 'assert contract function input type');
        $this->assertEquals($json['components'], $input->components(), $message . 'assert contract function input indexed');
    }

    private function makeContractEventJson(array $inputs = [])
    {
        return [
            'name' => $this->faker()->name,
            'type' => 'event',
            'indexed' => $this->faker()->boolean,
            'anonymous' => $this->faker()->boolean,
            'inputs' => $inputs,
        ];
    }

    private function assertContractEvent(ContractEvent $event, array $json, string $message = '')
    {
        $eventMessage = $message;
        if ($message) {
            $eventMessage = ', ' . $message;
        }
        $this->assertEquals($json['name'], $event->name(), $eventMessage . 'assert contract event name');
        $this->assertEquals($json['anonymous'], $event->anonymous(), $eventMessage . 'assert contract event anonymous');

        if (array_key_exists('inputs', $json)) {
            $jsonInputsByName = [];

            foreach ($json['inputs'] as $inputJson) {
                $inputName = $inputJson['name'];
                $jsonInputsByName[$inputName] = $inputJson;
                $eventInput = $event->input($inputName);
                $this->assertContractEventInput($eventInput, $inputJson, $message);
            }

            foreach ($event->inputs() as $eventInput) {
                $inputJson = $jsonInputsByName[$eventInput->name()];
                $this->assertContractEventInput($eventInput, $inputJson, $message);
            }
        }
    }

    private function makeContractEventInputJson(array $data = []): array
    {
        return array_merge([
            'name' => $this->faker()->name,
            'type' => $this->randomValueType(),
            'indexed' => $this->faker()->boolean,
        ], $data);
    }

    private function assertContractEventInput(ContractEventInput $input, array $json, string $message = '')
    {
        if ($message) {
            $message = ', ' . $message;
        }
        $this->assertEquals($json['name'], $input->name(), $message . 'assert contract event input name');
        $this->assertEquals($json['type'], $input->type(), $message . 'assert contract event input type');
        $this->assertEquals($json['indexed'], $input->indexed(), $message . 'assert contract event input indexed');
    }

    private function randomValueType(): string
    {
        $types = [
            'int',
            'uint',
            'bytes',
            'string',
        ];

        $type = $this->faker()->randomElement($types);

        $makeArray = random_int(0, 1);
        if ($makeArray) {
            $makeFixedLength = random_int(0, 1);

            if ($makeFixedLength) {
                $type .= '[' . random_int(1, 5) . ']';
            } else {
                $type .= '[]';
            }
        }

        return $type;
    }
}
