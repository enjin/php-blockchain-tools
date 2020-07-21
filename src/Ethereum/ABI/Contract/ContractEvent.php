<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\Contract;

use Enjin\BlockchainTools\Ethereum\ABI\Contract;
use Enjin\BlockchainTools\Ethereum\ABI\ContractEventDecoder;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder;
use Enjin\BlockchainTools\HexConverter;
use InvalidArgumentException;
use kornrunner\Keccak;

class ContractEvent
{
    /**
     * @var string
     */
    protected $inputDecoderClass;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $anonymous;

    /**
     * @var array
     */
    protected $inputs = [];

    protected $topic;

    public function __construct(array $event, string $inputDecoderClass = DataBlockDecoder::class)
    {
        Contract::validateDecoderClass($inputDecoderClass);

        $this->name = $event['name'];
        $this->anonymous = $event['anonymous'] ?? false;
        $this->inputDecoderClass = $inputDecoderClass;

        $inputs = $event['inputs'] ?? [];

        foreach ($inputs as $input) {
            $inputName = $input['name'];
            $this->inputs[$inputName] = $input;
        }
    }

    public function name(): string
    {
        return $this->name;
    }

    public function input(string $name): ContractEventInput
    {
        if (!array_key_exists($name, $this->inputs)) {
            throw new InvalidArgumentException('invalid input name: ' . $name . ' for Contract Event: ' . $this->name());
        }

        return new ContractEventInput($this->inputs[$name]);
    }

    public function inputs(): array
    {
        return array_map(function (array $input) {
            return new ContractEventInput($input);
        }, $this->inputs);
    }

    public function anonymous(): bool
    {
        return $this->anonymous;
    }

    public function signature(): string
    {
        $args = [];
        /** @var ContractEventInput $input */
        foreach ($this->inputs() as $input) {
            $args[] = $input->type();
        }

        return $this->name() . '(' . implode(',', $args) . ')';
    }

    public function signatureTopic(): string
    {
        if (!$this->topic) {
            $hash = Keccak::hash($this->signature(), 256);
            $this->topic = HexConverter::prefix($hash);
        }

        return $this->topic;
    }

    public function decodeInput(array $topics, string $data): DataBlockDecoder
    {
        $decoder = new ContractEventDecoder($this->inputDecoderClass);

        return $decoder->decodeInput($this, $topics, $data);
    }
}
