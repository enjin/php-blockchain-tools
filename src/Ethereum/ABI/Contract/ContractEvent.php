<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use InvalidArgumentException;

class ContractEvent
{
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

    public function __construct(array $event)
    {
        $this->name = $event['name'];
        $this->anonymous = $event['anonymous'] ?? false;

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
            throw new InvalidArgumentException('invalid event input name: ' . $name . ' for Contract Event: ' . $this->name());
        }

        return new ContractEventInput($this->inputs[$name]);
    }

    public function inputs(): array
    {
        return $this->inputs;
    }

    public function anonymous(): bool
    {
        return $this->anonymous;
    }

    public function encodeInput(array $input): string
    {
    }

    public function decodeInput(string $input): array
    {
    }
}