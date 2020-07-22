<?php

namespace Tests\Unit\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\DataType;
use Tests\TestCase;

class DataTypeTest extends TestCase
{
    // public function testInvalidBaseType()
    // {
    //     $message = 'Invalid base type: not-valid-type';
    //     $this->assertInvalidArgumentException($message, function () {
    //         $dataType = new DataType([
    //             'rawType' => 'not-valid-type',
    //             'baseType' => 'not-valid-type',
    //             'bitSize' => 0,
    //             'arrayLength' => null,
    //             'decimalPrecision' => null,
    //             'aliasedFrom' => null,
    //         ]);
    //
    //         $dataType->encodeBaseType('foo');
    //     });
    //
    //     $message = 'Invalid base type: not-valid-type';
    //     $this->assertInvalidArgumentException($message, function () {
    //         $dataType = new DataType([
    //             'rawType' => 'not-valid-type',
    //             'baseType' => 'not-valid-type',
    //             'bitSize' => 0,
    //             'arrayLength' => null,
    //             'decimalPrecision' => null,
    //             'aliasedFrom' => null,
    //         ]);
    //
    //         $dataType->decodeBaseType('foo');
    //     });
    // }
}
