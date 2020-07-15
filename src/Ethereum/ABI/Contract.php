<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractEvent;
use Enjin\BlockchainTools\Ethereum\ABI\Contract\ContractFunction;
use Enjin\BlockchainTools\HexConverter;
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
     * @var array
     */
    protected $json;

    protected $functionsMeta = [];
    protected $functions = [];
    protected $eventsMeta = [];
    protected $events = [];

    public function __construct(string $name, string $address, array $json)
    {
        $this->name = $name;
        $this->address = $address;
        $this->json = $json;

        foreach ($json as $item) {
            $name = $item['name'];
            $type = $item['type'] ?? 'function';
            if ($type === 'function') {
                $this->functionsMeta[$name] = $item;
            } elseif ($type === 'event') {
                $this->eventsMeta[$name] = $item;
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

    public function functions(): array
    {
        $names = array_keys($this->functionsMeta);

        return array_map(function ($name) {
            return $this->function($name);
        }, $names);
    }

    public function function(string $name): ContractFunction
    {
        $isValid = array_key_exists($name, $this->functionsMeta);
        if (!$isValid) {
            throw new InvalidArgumentException('method name not found: ' . $name . ' for Contract: ' . $this->name());
        }

        $isInitialized = array_key_exists($name, $this->functions);
        if (!$isInitialized) {
            $meta = $this->functionsMeta[$name];
            $this->functions[$name] = new ContractFunction($meta);
        }

        return $this->functions[$name];
    }

    public function events(): array
    {
        $names = array_keys($this->eventsMeta);

        return array_map(function ($name) {
            return $this->event($name);
        }, $names);
    }

    public function event(string $name): ContractEvent
    {
        $isValid = array_key_exists($name, $this->eventsMeta);
        if (!$isValid) {
            throw new InvalidArgumentException('event name not found: ' . $name . ' for Contract: ' . $this->name());
        }

        $isInitialized = array_key_exists($name, $this->events);
        if (!$isInitialized) {
            $meta = $this->eventsMeta[$name];
            $this->events[$name] = new ContractEvent($meta);
        }

        return $this->events[$name];
    }

    public function decodeEventInput(array $topics, string $data)
    {
        $signatureTopic = $topics[0];
        $event = $this->findEventBySignatureTopic($signatureTopic);

        if (!$event) {
            throw new InvalidArgumentException('event with matching topic not found: ' . $signatureTopic);
        }

        return $event->decodeInput($topics, $data);
    }

    public function findEventBySignatureTopic(string $topic0): ?ContractEvent
    {
        foreach ($this->events() as $event) {
            if ($event->signatureTopic() == $topic0) {
                return $event;
            }
        }

        return null;
    }

    public function findFunctionByMethodId(string $methodId): ?ContractFunction
    {
        $methodId = HexConverter::unPrefix($methodId);
        foreach ($this->functions() as $function) {
            if ($function->methodId() == $methodId) {
                return $function;
            }
        }

        return null;
    }

    public function decodeFunctionInput(string $data)
    {
        $methodId = $this->getMethodIdFromData($data);
        $function = $this->findFunctionByMethodId($methodId);

        if (!$function) {
            throw new InvalidArgumentException('function with matching methodId not found: ' . $methodId);
        }

        return $function->decodeInput($data);
    }

    public function decodeFunctionOutput(string $data)
    {
        $methodId = $this->getMethodIdFromData($data);
        $function = $this->findFunctionByMethodId($methodId);

        if (!$function) {
            throw new InvalidArgumentException('function with matching methodId not found: ' . $methodId);
        }

        return $function->decodeOutput($data);
    }

    protected function getMethodIdFromData(string $data): string
    {
        $data = HexConverter::unPrefix($data);

        return substr($data, 0, 8);
    }
}
