<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Tests\TestCase;

class SerializerTest extends TestCase
{
    public function testInvalid()
    {
        $message = 'Decoder class must be an instance of: Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder, invalid-decoder provided';
        $this->assertInvalidArgumentException($message, function () {
            new Serializer(
                'invalid-decoder'
            );
        });

        $message = 'Encoder class must be an instance of: Enjin\BlockchainTools\Ethereum\ABI\DataBlockEncoder, invalid-encoder provided';
        $this->assertInvalidArgumentException($message, function () {
            new Serializer(
                DataBlockDecoder::class,
                'invalid-encoder'
            );
        });
    }
}
