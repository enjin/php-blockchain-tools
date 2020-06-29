<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use InvalidArgumentException;
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

        $this->expectException(InvalidArgumentException::class);
        $contract->function('invalid_function');
    }

    public function testInvalidEvent()
    {
        $name = $this->faker()->name;
        $address = $this->faker()->ethAddress;
        $json = [];

        $contract = new Contract($name, $address, $json);

        $this->expectException(InvalidArgumentException::class);
        $contract->event('invalid_event');
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
}
