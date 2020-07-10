<?php

namespace Enjin\BlockchainTools\Ethereum\ABI;

use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\Exceptions\InvalidFixedDecimalPrecisionException;
use Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\Exceptions\InvalidNumberLengthException;
use Enjin\BlockchainTools\HexNumber\HexNumber;
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
            $length = $parsed->length();
            $aliasedFrom = $parsed->aliasedFrom();
            $decimalPrecision = $parsed->decimalPrecision();

            if ($aliasedFrom) {
                if ($arrayLength === 'dynamic') {
                    $arraySuffix = '[]';
                } else {
                    $arraySuffix = '[' . $arrayLength . ']';
                }

                $type = $baseType . $length . $arraySuffix;
                $aliasedFrom = $aliasedFrom . $arraySuffix;
            }

            return new DataType([
                'rawType' => $type,
                'baseType' => $baseType,
                'length' => $length,
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
                'length' => 'dynamic',
            ]);
        }

        if ($type === 'bool') {
            return new DataType([
                'rawType' => 'uint8',
                'baseType' => 'uint',
                'length' => 8,
                'aliasedFrom' => 'bool',
            ]);
        }

        if ($type === 'function') {
            return new DataType([
                'rawType' => 'bytes24',
                'baseType' => 'bytes',
                'length' => 24,
                'aliasedFrom' => 'function',
            ]);
        }

        if ($type === 'address') {
            return new DataType([
                'rawType' => 'address',
                'baseType' => 'address',
                'length' => 160,
            ]);
        }

        if ($this->startsWith($type, 'fixed')) {
            return $this->parseFixed($type, 'fixed');
        }

        if ($this->startsWith($type, 'bytes')) {
            return $this->parseBytes($type, 'bytes');
        }

        if ($this->startsWith($type, 'int')) {
            return $this->parseInt($type, 'int');
        } elseif ($this->startsWith($type, 'uint')) {
            return $this->parseInt($type, 'uint');
        }

        throw new InvalidArgumentException('Invalid type: ' . $type);
    }

    public function parseInt(string $type, string $baseType)
    {
        if ($type === $baseType) {
            $length = 256;
        } else {
            $length = $this->parseNumberLength($type, $baseType, HexNumber::VALID_BIT_SIZES);
        }

        return new DataType([
            'rawType' => $type,
            'baseType' => $baseType,
            'length' => $length,
        ]);
    }

    public function parseFixed(string $type, string $baseType)
    {
        if ($type === $baseType) {
            $length = 128;
            $decimalPrecision = 18;
        } else {
            $suffix = $this->removeFromBeginning($type, $baseType);

            [$length, $decimalPrecision] = explode('x', $suffix, 2);

            $length = (int) $length;
            $decimalPrecision = (int) $decimalPrecision;

            if (!in_array($length, HexNumber::VALID_BIT_SIZES)) {
                throw new InvalidNumberLengthException($baseType, $type);
            }

            if ($decimalPrecision < 1 || 80 < $decimalPrecision) {
                throw new InvalidFixedDecimalPrecisionException($baseType, $type);
            }
        }

        return new DataType([
            'rawType' => $type,
            'baseType' => $baseType,
            'length' => $length,
            'decimalPrecision' => $decimalPrecision,
        ]);
    }

    public function parseBytes(string $type, string $baseType)
    {
        if ($type === $baseType) {
            $length = 'dynamic';
        } else {
            $length = $this->parseNumberLength($type, $baseType, $this->validByteLengths());
        }

        return new DataType([
            'rawType' => $type,
            'baseType' => $baseType,
            'length' => $length,
        ]);
    }

    public function parseNumberLength(string $type, string $numberType, array $validLengths): int
    {
        $length = (int) $this->removeFromBeginning($type, $numberType);

        if (!in_array($length, $validLengths)) {
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

    protected function startsWith(string $haystack, string $needle)
    {
        return substr($haystack, 0, strlen($needle)) === (string) $needle;
    }

    protected function removeFromBeginning(string $string, string $prefix)
    {
        return substr($string, strlen($prefix));
    }

    private function validByteLengths(): array
    {
        return range(1, 32);
    }
}
