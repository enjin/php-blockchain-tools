<?php

declare(strict_types=1);

namespace Enjin\BlockchainTools\Support;

class StringHelpers
{
    public static function startsWith(string $haystack, string $prefix): bool
    {
        return substr($haystack, 0, strlen($prefix)) === (string) $prefix;
    }

    public static function removeFromBeginning(string $string, string $prefix): string
    {
        if (static::startsWith($string, $prefix)) {
            return substr($string, strlen($prefix));
        }

        return $string;
    }
}
