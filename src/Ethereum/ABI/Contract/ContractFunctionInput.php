<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

class ContractFunctionInput
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

    public function __construct(array $input)
    {
        $this->name = $input['name'];
        $this->type = $input['type'];
        $this->components = $input['components'] ?? null;
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
}
