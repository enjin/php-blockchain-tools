<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

class ContractEventInput
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $components;

    /**
     * @var mixed
     */
    protected $indexed;

    public function __construct(array $input)
    {
        $this->name = $input['name'];
        $this->type = $input['type'];
        $this->components = $input['components'] ?? null;
        $this->indexed = $input['indexed'];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function components(): array
    {
        return $this->components;
    }

    public function indexed(): bool
    {
        return $this->indexed;
    }
}
