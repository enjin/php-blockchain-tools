<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

class DataType
{
    /**
     * @var string
     */
    protected $baseType;

    /**
     * @var int|string
     */
    protected $bitSize;

    /**
     * @var int|string
     */
    protected $arrayLength;

    /**
     * @var string
     */
    protected $rawType;

    /**
     * @var null
     */
    protected $decimalPrecision;

    /**
     * @var string|null
     */
    protected $aliasedFrom;
    
    /**
     * @var array|null
     */
    protected $components;

    public function __construct(array $data)
    {
        $defaults = [
            'rawType' => null,
            'baseType' => null,
            'bitSize' => null,
            'arrayLength' => null,
            'decimalPrecision' => null,
            'aliasedFrom' => null,
            'components' => null,
        ];
        
        $data = array_merge($defaults, $data);

        $this->setData(
            $data['rawType'],
            $data['baseType'],
            $data['bitSize'],
            $data['arrayLength'],
            $data['decimalPrecision'],
            $data['aliasedFrom'],
            $data['components'],
        );
    }

    public function rawType(): string
    {
        return $this->rawType;
    }

    public function baseType(): string
    {
        return $this->baseType;
    }

    public function bitSize()
    {
        return $this->bitSize;
    }
    
    public function components(): ?array
    {
        return $this->components;
    }

    public function arrayLength()
    {
        return $this->arrayLength;
    }

    public function isArray(): bool
    {
        return $this->arrayLength !== null;
    }

    public function isDynamicLengthArray()
    {
        return $this->isArray() && $this->arrayLength() === 'dynamic';
    }

    public function isFixedLengthArray()
    {
        return $this->isArray() && $this->arrayLength() !== 'dynamic';
    }

    public function decimalPrecision(): ?int
    {
        return $this->decimalPrecision;
    }

    public function aliasedFrom(): ?string
    {
        return $this->aliasedFrom;
    }

    protected function setData(
        string $rawType,
        string $baseType,
        $bitSize = null,
        $arrayLength = null,
        int $decimalPrecision = null,
        string $aliasedFrom = null,
        array $components = null
    ) {
        $this->rawType = $rawType;
        $this->baseType = $baseType;
        $this->bitSize = $bitSize;
        $this->arrayLength = $arrayLength;
        $this->decimalPrecision = $decimalPrecision;
        $this->aliasedFrom = $aliasedFrom;
        $this->components = $components;
    }
}
