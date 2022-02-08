<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\HexNumber\HexNumber;
use Enjin\BlockchainTools\Support\StringHelpers as Str;
use InvalidArgumentException;

class DataTypeParser
{
    public function parse(string $type): DataType
    {
        if (substr($type, -1) === ']') {
            $this->parseArray($type);
        }

        return $this->parseType($type);
    }

    public function parseType(string $type)
    {
        if ($type === 'string') {
            return new DataType([
                'rawType' => $type,
                'baseType' => $type,
                'bitSize' => 'dynamic',
            ]);
        }

        if ($type === 'bool') {
            return new DataType([
                'rawType' => 'uint8',
                'baseType' => 'uint',
                'bitSize' => 8,
                'aliasedFrom' => 'bool',
            ]);
        }

        if ($type === 'function') {
            return new DataType([
                'rawType' => 'bytes24',
                'baseType' => 'bytes',
                'bitSize' => 24,
                'aliasedFrom' => 'function',
            ]);
        }

        if ($type === 'address') {
            return new DataType([
                'rawType' => 'address',
                'baseType' => 'address',
                'bitSize' => 160,
            ]);
        }
    
        if ($type === 'tuple') {
            return new DataType([
                'rawType' => 'tuple',
                'baseType' => 'tuple',
                'bitSize' => 'dynamic',
            ]);
        }

        if (Str::startsWith($type, 'fixed')) {
            return $this->parseFixed($type, 'fixed');
        }

        if (Str::startsWith($type, 'bytes')) {
            return $this->parseBytes($type, 'bytes');
        }

        if (Str::startsWith($type, 'int')) {
            return $this->parseInt($type, 'int');
        } elseif (Str::startsWith($type, 'uint')) {
            return $this->parseInt($type, 'uint');
        }

        throw new InvalidArgumentException('Invalid type: ' . $type);
    }

    public function parseInt(string $type, string $baseType)
    {
        if ($type === $baseType) {
            $bitSize = 256;
        } else {
            $bitSize = $this->parseNumberBitSize($type, $baseType, HexNumber::VALID_BIT_SIZES);
        }

        return new DataType([
            'rawType' => $type,
            'baseType' => $baseType,
            'bitSize' => $bitSize,
        ]);
    }

    public function parseFixed(string $type, string $baseType)
    {
        if ($type === $baseType) {
            $bitSize = 128;
            $decimalPrecision = 18;
        } else {
            $suffix = Str::removeFromBeginning($type, $baseType);

            [$bitSize, $decimalPrecision] = explode('x', $suffix, 2);

            if (!is_numeric($bitSize)) {
                throw new InvalidArgumentException('invalid bit size: ' . $bitSize . ', in: ' . $type);
            }

            if (!is_numeric($decimalPrecision)) {
                throw new InvalidArgumentException('invalid decimal precision: ' . $decimalPrecision . ', in: ' . $type);
            }

            $bitSize = (int) $bitSize;
            $decimalPrecision = (int) $decimalPrecision;

            if (!in_array($bitSize, HexNumber::VALID_BIT_SIZES)) {
                throw new InvalidArgumentException('invalid bit size: ' . $bitSize . ', in: ' . $type);
            }

            if ($decimalPrecision < 1 || 80 < $decimalPrecision) {
                throw new InvalidArgumentException('invalid decimal precision: ' . $decimalPrecision . ', in: ' . $type);
            }
        }

        return new DataType([
            'rawType' => $type,
            'baseType' => $baseType,
            'bitSize' => $bitSize,
            'decimalPrecision' => $decimalPrecision,
        ]);
    }

    public function parseBytes(string $type, string $baseType)
    {
        if ($type === $baseType) {
            $bitSize = 'dynamic';
        } else {
            $bitSize = $this->parseNumberBitSize($type, $baseType, $this->validByteLengths());
        }

        return new DataType([
            'rawType' => $type,
            'baseType' => $baseType,
            'bitSize' => $bitSize,
        ]);
    }

    public function parseNumberBitSize(string $type, string $numberType, array $validBitSizes): int
    {
        $length = (int) Str::removeFromBeginning($type, $numberType);

        if (!in_array($length, $validBitSizes)) {
            $message = 'invalid ' . $numberType . ' bit size in type: ' . $type;

            throw new InvalidArgumentException($message);
        }

        return $length;
    }
    
    public function parseArray(string $type) {
        $arrayMeta = $this->parseArrayLength($type);
        $arrayLength = $arrayMeta['length'];
        $arrayType = $arrayMeta['type'];
    
        $parsed = $this->parseType($arrayType);
    
        $baseType = $parsed->baseType();
        $bitSize = $parsed->bitSize();
        $aliasedFrom = $parsed->aliasedFrom();
        $decimalPrecision = $parsed->decimalPrecision();
    
        if ($aliasedFrom) {
            if ($arrayLength === 'dynamic') {
                $arraySuffix = '[]';
            } else {
                $arraySuffix = '[' . $arrayLength . ']';
            }
        
            $type = $baseType . $bitSize . $arraySuffix;
            $aliasedFrom = $aliasedFrom . $arraySuffix;
        }
    
        return new DataType([
            'rawType' => $type,
            'baseType' => $baseType,
            'bitSize' => $bitSize,
            'arrayLength' => $arrayLength,
            'decimalPrecision' => $decimalPrecision,
            'aliasedFrom' => $aliasedFrom,
        ]);
    }

    public function parseArrayLength(string $type)
    {
        $last2 = substr($type, -2);
        if ($last2 === '[]') {
            return [
                'type' => substr($type, 0, -2),
                'length' => 'dynamic',
            ];
        }

        preg_match('/(.*?)\[([0-9]+)\]/', $type, $matches);

        if (!array_key_exists(1, $matches)) {
            $message = 'invalid array length in type: ' . $type;

            throw new InvalidArgumentException($message);
        }

        return [
            'type' => $matches[1],
            'length' => (int) $matches[2],
        ];
    }

    private function validByteLengths(): array
    {
        return range(1, 32);
    }
}
