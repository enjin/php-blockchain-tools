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

    protected $functionSerializers = [];
    protected $eventInputSerializers = [];

    /**
     * @var Serializer
     */
    protected $defaultSerializer;

    public function __construct(
        string $name,
        string $address,
        array $json,
        array $serializers = []
    ) {
        $serializer = $serializers['default'] ?? Serializer::makeDefault();

        $this->setDefaultSerializer($serializer);
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

        foreach ($serializers['functions'] ?? [] as $name => $config) {
            $this->registerFunctionSerializers(
                $name,
                $config['default'] ?? null,
                $config['input'] ?? null,
                $config['output'] ?? null
            );
        }

        foreach ($serializers['events'] ?? [] as $name => $serializer) {
            $this->registerEventSerializer($name, $serializer);
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
        $this->validateFunctionName($name);

        $isInitialized = array_key_exists($name, $this->functions);
        if (!$isInitialized) {
            $this->functions[$name] = $this->makeFunction($name);
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
        $this->validateEventName($name);

        $isInitialized = array_key_exists($name, $this->events);
        if (!$isInitialized) {
            $this->events[$name] = $this->makeEvent($name);
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

    protected function validateEventName(string $name)
    {
        $isValid = array_key_exists($name, $this->eventsMeta);
        if (!$isValid) {
            throw new InvalidArgumentException('event name not found: ' . $name . ' for Contract: ' . $this->name());
        }
    }

    protected function validateFunctionName(string $name): void
    {
        $isValid = array_key_exists($name, $this->functionsMeta);
        if (!$isValid) {
            $message = 'method name not found: ' . $name . ' for Contract: ' . $this->name();

            throw new InvalidArgumentException($message);
        }
    }

    protected function registerFunctionSerializers(
        string $name,
        Serializer $default = null,
        Serializer $input = null,
        Serializer $output = null
    ) {
        $this->validateFunctionName($name);

        $this->functionSerializers[$name] = [
            'default' => $default,
            'input' => $input,
            'output' => $output,
        ];
    }

    protected function registerEventSerializer(string $name, Serializer $serializer)
    {
        $this->validateEventName($name);

        $this->eventInputSerializers[$name] = $serializer;
    }

    protected function setDefaultSerializer(Serializer $defaultSerializer)
    {
        $this->defaultSerializer = $defaultSerializer;
    }

    protected function makeFunction(string $name): ContractFunction
    {
        $meta = $this->functionsMeta[$name];

        $default = $this->functionSerializers[$name]['default'] ?? $this->defaultSerializer;
        $input = $this->functionSerializers[$name]['input'] ?? null;
        $output = $this->functionSerializers[$name]['output'] ?? null;

        return new ContractFunction(
            $meta,
            $default,
            $input,
            $output
        );
    }

    protected function makeEvent(string $name): ContractEvent
    {
        $meta = $this->eventsMeta[$name];
        $serializer = $this->eventInputSerializers[$name] ?? $this->defaultSerializer;

        return new ContractEvent(
            $meta,
            $serializer
        );
    }
}
