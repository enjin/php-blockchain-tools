<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\Contract;

class ContractEventInput extends ContractFunctionValueType
{
    /**
     * @var bool
     */
    protected $indexed;

    public function __construct(array $input)
    {
        parent::__construct($input);
        $this->indexed = $input['indexed'] ?? false;
    }

    public function indexed(): bool
    {
        return $this->indexed;
    }
}
