<?php

namespace Enjin\BlockchainTools\HexNumber\Concerns;

use InvalidArgumentException;

trait ConvertsByBitSize
{
    public function convertUpTo(int $bitSize): string
    {
        if ($bitSize < static::BIT_SIZE) {
            throw new InvalidArgumentException('Cannot convert up to ' . $bitSize . ' from ' . static::BIT_SIZE . '. Can only convert up to larger bit sizes');
        }

        $length = $bitSize / 4;

        return static::padLeft($this->value, $length);
    }

    public function convertDownToTop(int $bitSize): string
    {
        return $this->topByBitSize($bitSize, true);
    }

    public function convertDownToBottom(int $bitSize): string
    {
        return $this->bottomByBitSize($bitSize, true);
    }

    public function forceConvertDownToTop(int $bitSize): string
    {
        return $this->topByBitSize($bitSize, false);
    }

    public function forceConvertDownToBottom(int $bitSize): string
    {
        return $this->bottomByBitSize($bitSize, false);
    }

    protected function topByBitSize(int $bitSize, bool $preventDataLoss = false): string
    {
        if ($bitSize > static::BIT_SIZE) {
            throw new InvalidArgumentException('Cannot convert down to ' . $bitSize . ' from ' . static::BIT_SIZE . '. Can only convert down to smaller bit sizes');
        }
        $length = $bitSize / 4;
        $message = 'Cannot safely convert down to top of ' . $bitSize . ' from ' . static::BIT_SIZE;

        return $this->topCharacters($length, $preventDataLoss, $message);
    }

    protected function bottomByBitSize(int $bitSize, bool $preventDataLoss = false): string
    {
        if ($bitSize > static::BIT_SIZE) {
            throw new InvalidArgumentException('Cannot convert down to ' . $bitSize . ' from ' . static::BIT_SIZE . '. Can only convert down to smaller bit sizes');
        }

        $length = $bitSize / 4;
        $message = 'Cannot safely convert down to bottom of ' . $bitSize . ' from ' . static::BIT_SIZE;

        return $this->bottomCharacters($length, $preventDataLoss, $message);
    }
}
