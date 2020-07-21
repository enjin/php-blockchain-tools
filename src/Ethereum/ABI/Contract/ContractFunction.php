<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\Contract;

use Enjin\BlockchainTools\Ethereum\ABI\ContractFunctionDecoder;
use Enjin\BlockchainTools\Ethereum\ABI\ContractFunctionEncoder;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockDecoder;
use Enjin\BlockchainTools\Ethereum\ABI\DataBlockEncoder;
use InvalidArgumentException;
use kornrunner\Keccak;

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
    protected $inputs = [];

    /**
     * @var array
     */
    protected $outputs = [];

    /**
     * @var string
     */
    protected $methodId;

    /**
     * @var string
     */
    protected $topic;

    public function __construct(array $function)
    {
        $stateMutability = $function['stateMutability'];

        $this->name = $function['name'];
        $this->payable = $stateMutability === 'payable';
        $this->constant = in_array($stateMutability, ['pure', 'view']);
        $this->stateMutability = $stateMutability;

        $inputs = $function['inputs'] ?? [];

        foreach ($inputs as $input) {
            $inputName = $input['name'];
            $this->inputs[$inputName] = $input;
        }

        $outputs = $function['outputs'] ?? [];

        foreach ($outputs as $output) {
            $outputName = $output['name'];
            $this->outputs[$outputName] = $output;
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

    public function input(string $name): ContractFunctionValueType
    {
        if (!array_key_exists($name, $this->inputs)) {
            throw new InvalidArgumentException('invalid input name: ' . $name . ' for Contract Function: ' . $this->name());
        }

        return new ContractFunctionValueType($this->inputs[$name]);
    }

    public function outputs(): array
    {
        return array_map(function (array $output) {
            return new ContractFunctionValueType($output);
        }, $this->outputs);
    }

    public function output(string $name): ContractFunctionValueType
    {
        if (!array_key_exists($name, $this->outputs)) {
            throw new InvalidArgumentException('invalid output name: ' . $name . ' for Contract Function: ' . $this->name());
        }

        return new ContractFunctionValueType($this->outputs[$name]);
    }

    public function inputs(): array
    {
        return array_map(function (array $input) {
            return new ContractFunctionValueType($input);
        }, $this->inputs);
    }

    public function signature(): string
    {
        $args = [];
        /** @var ContractFunctionValueType $input */
        foreach ($this->inputs() as $input) {
            $args[] = $input->type();
        }

        return $this->name() . '(' . implode(',', $args) . ')';
    }

    public function methodId(): string
    {
        if (!$this->methodId) {
            $hash = Keccak::hash($this->signature(), 256);

            // first 4 bytes of method signature
            $this->methodId = substr($hash, 0, 8);
        }

        return $this->methodId;
    }

    public function encodeInput(array $data): DataBlockEncoder
    {
        return (new ContractFunctionEncoder())->encodeInput($this, $data);
    }

    public function decodeInput(string $data): DataBlockDecoder
    {
        return (new ContractFunctionDecoder())->decodeInput($this, $data);
    }

    public function encodeOutput(array $data): DataBlockEncoder
    {
        return (new ContractFunctionEncoder())->encodeOutput($this, $data);
    }

    public function decodeOutput(string $data): DataBlockDecoder
    {
        return (new ContractFunctionDecoder())->decodeOutput($this, $data);
    }
}
