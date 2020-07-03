<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\Contract;

use Enjin\BlockchainTools\HexConverter;
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
    protected $inputs;

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
        return array_map(function (array $input) {
            return new ContractFunctionInput($input);
        }, $this->inputs);
    }

    public function signature(): string
    {
        $args = [];
        /** @var ContractFunctionInput $input */
        foreach ($this->inputs() as $input) {
            $args[] = $input->type();
        }

        return $this->name() . '(' . implode(',', $args) . ')';
    }

    public function methodId(): string
    {
        if (!$this->methodId) {
            $topic = $this->topic();
            $topic = HexConverter::unPrefix($topic);

            // first 4 bytes of method signature
            return '0x' . substr($topic, 0, 8);
        }

        return $this->methodId;
    }

    public function topic(): string
    {
        if (!$this->topic) {
            $hash = Keccak::hash($this->signature(), 256);
            $this->topic = HexConverter::prefix($hash);
        }

        return $this->topic;
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
