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

    protected $functionInputSerializers = [];
    protected $functionOutputSerializers = [];
    protected $eventInputSerializers = [];

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
        string $defaultEncoderClass = DataBlockEncoder::class,
        string $defaultDecoderClass = DataBlockDecoder::class
    ) {
        static::validateDecoderClass($defaultDecoderClass);
        static::validateEncoderClass($defaultEncoderClass);

        $this->name = $name;
        $this->address = $address;
        $this->json = $json;
        $this->defaultEncoderClass = $defaultEncoderClass;
        $this->defaultDecoderClass = $defaultDecoderClass;

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
        $this->validateFunctionName($name);

        $isInitialized = array_key_exists($name, $this->functions);
        if (!$isInitialized) {
            $meta = $this->functionsMeta[$name];

            $input = $this->functionInputSerializers[$name] ?? $this->defaultSerializers();
            $output = $this->functionOutputSerializers[$name] ?? $this->defaultSerializers();

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

    public function registerFunctionInputSerializers(string $name, string $decoderClass, string $encoderClass)
    {
        $this->functionInputSerializers[$name] = $this->parseFunctionSerializers($name, $decoderClass, $encoderClass);
    }

    public function registerFunctionOutputSerializers(string $name, string $decoderClass, string $encoderClass)
    {
        $this->functionOutputSerializers[$name] = $this->parseFunctionSerializers($name, $decoderClass, $encoderClass);
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

            $input = $this->eventInputSerializers[$name] ?? $this->defaultSerializers();

            $this->events[$name] = new ContractEvent(
                $meta,
                $input['decoder'],
                $input['encoder']
            );
        }

        return $this->events[$name];
    }

    public function registerEventInputSerializers(string $name, string $decoderClass, string $encoderClass)
    {
        $this->validateEventName($name);
        static::validateDecoderClass($decoderClass);
        static::validateEncoderClass($encoderClass);

        $this->eventInputSerializers[$name] = [
            'decoder' => $decoderClass,
            'encoder' => $encoderClass,
        ];
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
            throw new InvalidArgumentException('Value must be name of a class that is an instance of: ' . DataBlockDecoder::class . ', ' . $decoder . ' provided');
        }
    }

    public static function validateEncoderClass(string $encoder)
    {
        if (!is_a($encoder, DataBlockEncoder::class, true)) {
            throw new InvalidArgumentException('Value must be name of a class that is an instance of: ' . DataBlockEncoder::class);
        }
    }

    protected function parseFunctionSerializers(string $name, string $decoderClass, string $encoderClass): array
    {
        $this->validateFunctionName($name);
        static::validateDecoderClass($decoderClass);
        static::validateEncoderClass($encoderClass);

        return [
            'decoder' => $decoderClass,
            'encoder' => $encoderClass,
        ];
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

    protected function defaultSerializers(): array
    {
        return [
            'encoder' => $this->defaultEncoderClass,
            'decoder' => $this->defaultDecoderClass,
        ];
    }
}
