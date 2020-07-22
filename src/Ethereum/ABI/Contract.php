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
    protected $eventInputDecoders = [];

    /**
     * @var string
     */
    protected $defaultEncoderClass;

    /**
     * @var string
     */
    protected $defaultDecoderClass;

    public function __construct(
        string $name,
        string $address,
        array $json,
        array $serializers = []
    ) {
        $defaultDecoderClass = $serializers['decoder'] ?? DataBlockDecoder::class;
        $defaultEncoderClass = $serializers['encoder'] ?? DataBlockEncoder::class;
        static::validateDecoderClass($defaultDecoderClass);
        static::validateEncoderClass($defaultEncoderClass);

        $this->name = $name;
        $this->address = $address;
        $this->json = $json;
        $this->defaultDecoderClass = $defaultDecoderClass;
        $this->defaultEncoderClass = $defaultEncoderClass;

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
            $this->registerFunctionSerializers($name, $config);
        }

        foreach ($serializers['events'] ?? [] as $name => $decoder) {
            $this->registerEventInputDecoder($name, $decoder);
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
            $meta = $this->functionsMeta[$name];

            $default = $this->functionSerializers[$name]['default'] ?? [];
            $default = $default ?: $this->defaultSerializer();

            $input = $this->functionSerializers[$name]['input'] ?? [];
            $output = $this->functionSerializers[$name]['output'] ?? [];

            $input = array_merge($default, $input);
            $output = array_merge($default, $output);

            $this->functions[$name] = new ContractFunction(
                $meta,
                $input['decoder'],
                $input['encoder'],
                $output['decoder'],
                $output['encoder']
            );
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
            $meta = $this->eventsMeta[$name];

            $decoder = $this->eventInputDecoders[$name] ?? $this->defaultDecoderClass;

            $this->events[$name] = new ContractEvent(
                $meta,
                $decoder
            );
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

    public static function validateDecoderClass(string $decoder)
    {
        if (!is_a($decoder, DataBlockDecoder::class, true)) {
            throw new InvalidArgumentException('Decoder class must be an instance of: ' . DataBlockDecoder::class . ', ' . $decoder . ' provided');
        }
    }

    public static function validateEncoderClass(string $encoder)
    {
        if (!is_a($encoder, DataBlockEncoder::class, true)) {
            throw new InvalidArgumentException('Encoder class must be an instance of: ' . DataBlockEncoder::class . ', ' . $encoder . ' provided');
        }
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

    protected function defaultSerializer(): array
    {
        return [
            'encoder' => $this->defaultEncoderClass,
            'decoder' => $this->defaultDecoderClass,
        ];
    }

    protected function registerFunctionSerializers(string $name, array $config)
    {
        $this->validateFunctionName($name);

        $default = $this->parseSerializers($config);

        $input = $config['input'] ?? [];
        $output = $config['output'] ?? [];

        $input = $this->parseSerializers($input);
        $output = $this->parseSerializers($output);

        $this->functionSerializers[$name] = [
            'default' => $default,
            'input' => $input,
            'output' => $output,
        ];
    }

    protected function registerEventInputDecoder(string $name, string $decoder)
    {
        $this->validateEventName($name);
        static::validateDecoderClass($decoder);

        $this->eventInputDecoders[$name] = $decoder;
    }

    protected function parseSerializers(array $serializer): array
    {
        $decoderClass = $serializer['decoder'] ?? false;
        $encoderClass = $serializer['encoder'] ?? false;

        $output = [];

        if ($decoderClass) {
            static::validateDecoderClass($decoderClass);
            $output['decoder'] = $decoderClass;
        }

        if ($encoderClass) {
            static::validateEncoderClass($encoderClass);
            $output['encoder'] = $encoderClass;
        }

        return $output;
    }
}
