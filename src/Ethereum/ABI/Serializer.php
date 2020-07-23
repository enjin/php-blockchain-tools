<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use InvalidArgumentException;

class Serializer
{
    /**
     * @var string
     */
    protected $decoder;

    /**
     * @var string
     */
    protected $encoder;

    public function __construct(string $decoder = DataBlockDecoder::class, string $encoder = DataBlockEncoder::class)
    {
        $this->decoder = $this->validateDecoderClass($decoder);
        $this->encoder = $this->validateEncoderClass($encoder);
    }

    public static function makeDefault(): self
    {
        return new self(
            DataBlockDecoder::class,
            DataBlockEncoder::class
        );
    }

    public function decoder(array $functionValueTypes): DataBlockDecoder
    {
        return new $this->decoder($functionValueTypes);
    }

    public function encoder(array $functionValueTypes): DataBlockEncoder
    {
        return new $this->encoder($functionValueTypes);
    }

    public function validateDecoderClass(string $decoder): string
    {
        if (!is_a($decoder, DataBlockDecoder::class, true)) {
            throw new InvalidArgumentException('Decoder class must be an instance of: ' . DataBlockDecoder::class . ', ' . $decoder . ' provided');
        }

        return $decoder;
    }

    public function validateEncoderClass(string $encoder): string
    {
        if (!is_a($encoder, DataBlockEncoder::class, true)) {
            throw new InvalidArgumentException('Encoder class must be an instance of: ' . DataBlockEncoder::class . ', ' . $encoder . ' provided');
        }

        return $encoder;
    }
}
