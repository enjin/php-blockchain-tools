<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use InvalidArgumentException;

class ContractFunction
{
    public const MUTABILITY_PURE = 'pure';
    public const MUTABILITY_VIEW = 'view';
    public const MUTABILITY_NONPAYABLE = 'nonpayable';
    public const MUTABILITY_PAYABLE = 'payable';

    public const VALID_MUTABILITY_VALUES = [
        self::MUTABILITY_PURE,
        self::MUTABILITY_VIEW,
        self::MUTABILITY_NONPAYABLE,
        self::MUTABILITY_PAYABLE,
    ];

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $stateMutability;

    /**
     * @var bool
     */
    protected $payable;

    /**
     * @var bool
     */
    protected $constant;

    /**
     * @var array
     */
    protected $inputs;

    public function __construct(array $function)
    {
        $this->name = $function['name'];
        $this->payable = $function['payable'];
        $this->constant = $function['constant'] ?? null;
        $this->stateMutability = $function['stateMutability'];

        $inputs = $function['inputs'] ?? [];

        foreach ($inputs as $input) {
            $inputName = $input['name'];
            $this->inputs[$inputName] = $input;
        }
    }

    public function name(): string
    {
        return $this->name;
    }

    public function stateMutability(): string
    {
        return $this->stateMutability;
    }

    public function payable(): bool
    {
        return $this->payable;
    }

    public function constant(): bool
    {
        return $this->constant;
    }

    public function input(string $name): ContractFunctionInput
    {
        if (!array_key_exists($name, $this->inputs)) {
            throw new InvalidArgumentException('invalid function input name: ' . $name . ' for Contract Function: ' . $this->name());
        }

        return new ContractFunctionInput($this->inputs[$name]);
    }

    public function inputs(): array
    {
        return $this->inputs;
    }

    public function outputs(): array
    {
    }

    public function encodeInput(array $input): string
    {
    }

    public function decodeInput(string $input): array
    {
    }

    public function encodeOutput(array $input): string
    {
    }

    public function decodeOutput(string $input): array
    {
    }
}
