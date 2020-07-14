<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\ContractStore;
use Tests\TestCase;

class ContractStoreTest extends TestCase
{
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

        $data = '0x' . implode('', $serialized);

        $result = $store->decodeEvent('test-address', $topics, $data);
        $this->assertEquals($expected, $result);
    }
}
