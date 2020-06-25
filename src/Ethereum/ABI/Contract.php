<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use InvalidArgumentException;

class Contract
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var array
     */
    protected $json;

    /**
     * @var array
     */
    protected $functions = [];

    /**
     * @var array
     */
    protected $events = [];

    public function __construct(string $name, string $address, string $version, array $json)
    {
        $this->name = $name;
        $this->address = $address;
        $this->version = $version;
        $this->json = $json;

        foreach ($json as $item) {
            $name = $item['name'];
            $type = $item['type'];
            if ($type === 'function') {
                $this->functions[$name] = $item;
            } else if ($type === 'event') {
                $this->events[$name] = $item;
            }
        }
    }

    public function name(): string
    {
        return $this->name;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function functions(): array
    {
        $functions = [];

        foreach ($this->functions as $function) {
            $functions[] = new ContractFunction($function);
        }

        return $functions;
    }

    public function function (string $name): ContractFunction
    {
        if (!array_key_exists($name, $this->functions)) {
            throw new InvalidArgumentException('invalid method name input: ' . $name . ' for Contract: ' . $this->name());
        }

        return new ContractFunction($this->functions[$name]);
    }

    public function events(): array
    {
        $events = [];

        foreach ($this->events as $event) {
            $events[] = new ContractEvent($event);
        }

        return $events;
    }

    public function event(string $name): ContractEvent
    {
        if (!array_key_exists($name, $this->events)) {
            throw new InvalidArgumentException('invalid event name input: ' . $name . ' for Contract: ' . $this->name());
        }
        return new ContractEvent($this->events[$name]);
    }
}