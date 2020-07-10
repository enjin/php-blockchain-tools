<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\Exceptions\InvalidFixedDecimalPrecisionException;
use Enjin\BlockchainTools\Ethereum\ABI\Exceptions\InvalidNumberLengthException;
use Enjin\BlockchainTools\HexNumber\HexNumber;
use Enjin\BlockchainTools\Support\StringHelpers as Str;
use InvalidArgumentException;

class DataTypeParser
{
    public function parse(string $type): DataType
    {
        $last1 = substr($type, -1);
        $isArray = $last1 === ']';

        if ($isArray) {
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

            list($bitSize, $decimalPrecision) = explode('x', $suffix, 2);

            $bitSize = (int) $bitSize;
            $decimalPrecision = (int) $decimalPrecision;

            if (!in_array($bitSize, HexNumber::VALID_BIT_SIZES)) {
                throw new InvalidNumberLengthException($baseType, $type);
            }

            if ($decimalPrecision < 1 || 80 < $decimalPrecision) {
                throw new InvalidFixedDecimalPrecisionException($baseType, $type);
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
            throw new InvalidNumberLengthException($numberType, $type);
        }

        return $length;
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
            throw new \Exception('could not parse fixed array length of type: ' . $type);
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
