<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEvent;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\Ethereum\ABI\ContractStore;
use Enjin\BlockchainTools\Ethereum\ABI\Exceptions\ContractFileException;
use Enjin\BlockchainTools\HexConverter;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt256;
use Enjin\BlockchainTools\HexNumber\HexUInt\HexUInt8;
use Tests\TestCase;

/**
 * @covers \Enjin\BlockchainTools\Ethereum\ABI\ContractStore
 */
class ContractStoreTest extends TestCase
{
    public function testContract()
    {
        $store = new ContractStore();

        $address = $this->faker()->ethAddress;
        $name = 'test-contract';
        $contractMeta = [
            'name' => $name,
            'address' => $address,
            'jsonFile' => __DIR__ . '/../../../Support/test-contract.json',
        ];

        $store->registerContracts([$contractMeta]);

        $contract = $store->contractByAddress($address);

        $expectedAddress = substr($address, 2);
        $expectedAddress = strtolower($expectedAddress);

        $this->assertEquals($expectedAddress, $contract->address());
        $this->assertEquals($name, $contract->name());

        $this->assertInstanceOf(ContractFunction::class, $contract->function('testFunction1'));
        $this->assertInstanceOf(ContractEvent::class, $contract->event('testEvent1'));

        $this->assertInvalidArgumentException('contract with address not found: invalid-addiress', function () use (
            $store
        ) {
            $store->contractByAddress('invalid-addiress');
        });

        $this->assertInvalidArgumentException('contract with name not found: invalid-name', function () use ($store) {
            $store->contract('invalid-name');
        });
    }

    public function testInvalidContractFile()
    {
        $store = new ContractStore();

        $name = 'invalid-json-contract';
        $jsonFile = __DIR__ . '/../../../Support/test-invalid-json-contract.json';
        $contractMeta = [
            'name' => $name,
            'address' => $this->faker()->ethAddress,
            'jsonFile' => $jsonFile,

        ];

        $store->registerContracts([
            $contractMeta,
        ]);

        $this->expectException(ContractFileException::class);
        $this->expectExceptionMessage('Contract file does not contain valid JSON: ' . $jsonFile);
        $store->contract($name);
    }

    public function testNotExistingContractFile()
    {
        $store = new ContractStore();

        $name = 'not-existing-contract';
        $jsonFile = __DIR__ . '/../../../Support/not-existing-contract.json';
        $contractMeta = [
            'name' => $name,
            'address' => $this->faker()->ethAddress,
            'jsonFile' => $jsonFile,

        ];

        $store->registerContracts([$contractMeta]);

        $this->expectException(ContractFileException::class);
        $this->expectExceptionMessage('Contract file not found: ' . $jsonFile);
        $store->contract($name);
    }

    public function testEndToEnd()
    {
        $store = new ContractStore();

        $contractMeta = [
            'name' => 'test-contract',
            'address' => 'test-address',
            'jsonFile' => __DIR__ . '/../../../Support/test-contract.json',
        ];

        $store->registerContracts([$contractMeta]);

        $contract = $store->contract('test-contract');

        $topic = $contract->event('testEvent1')->signatureTopic();

        $expected = [
            'myString' => HexConverter::stringToHex('Hello%!'),
            'myNumber' => HexUInt256::fromUInt(62224)->toHex(),
            'mySmallNumber' => HexUInt8::fromUInt(16)->toHexUInt256(),
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

        $data = '0x' . implode('', $serialized);

        $result = $store->decodeEvent('test-address', $topics, $data);
        $this->assertEquals($expected, $result->toArray());
    }
}
