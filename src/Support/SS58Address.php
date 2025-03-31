<?php

declare(strict_types=1);

namespace Enjin\BlockchainTools\Support;

use Enjin\BlockchainTools\HexConverter;
use Exception;
use SodiumException;
use Tuupola\Base58;

class SS58Address
{
    private const string CONTEXT = '53533538505245';

    private const int ENJIN_PREFIX = 1110;

    private const array ALLOWED_DECODED_LENGTHS = [
        1, 2, 4, 8, 32, 33,
    ];

    public static function isSameAddress(string $address1, string $address2): bool
    {
        try {
            return self::getPublicKey($address1) === self::getPublicKey($address2);
        } catch (Exception) {
            return false;
        }
    }

    public static function getPublicKey(string|array|null $address): ?string
    {
        if (empty($address)) {
            return null;
        }

        try {
            return HexConverter::prefix(HexConverter::bytesToHex(self::decode($address)));
        } catch (Exception) {
            return null;
        }
    }

    public static function decode(string|array $address, ?bool $ignoreChecksum = false, ?int $ss58Format = -1): array
    {
        if (empty($address)) {
            throw new Exception('Invalid empty address passed.');
        }

        $input = '';

        if (is_string($address) && ctype_xdigit($input = HexConverter::unPrefix($address))) {
            return HexConverter::hexToBytes($address);
        }

        if (is_array($address)) {
            foreach ($address as $c) {
                if ($c > 255 || $c < 0) {
                    throw new Exception('Invalid Uint8Array.');
                }
            }

            return $address;
        }

        try {
            $base58check = new Base58(['characters' => Base58::BITCOIN]);
            $buffer = $base58check->decode($input);
            $array = unpack('C*', $buffer);
            $bytes = array_values($array);

            [$isValid, $endPos, $ss58Length, $ss58Decoded] = self::checkAddressChecksum($bytes);

            if (!$ignoreChecksum && !$isValid) {
                throw new Exception('Invalid decoded address checksum.');
            }

            if (!in_array($ss58Format, [-1, $ss58Decoded], true)) {
                throw new Exception("Expected ss58Format {$ss58Format}, received {$ss58Decoded}.");
            }

            return array_slice($bytes, $ss58Length, $endPos - $ss58Length);
        } catch (Exception $e) {
            throw new Exception("Cannot decode {$address}: {$e->getMessage()}");
        }
    }

    public static function checkAddressChecksum(array $decoded): array
    {
        $ss58Length = $decoded[0] & 0b01000000 ? 2 : 1;

        $ss58Decoded = $ss58Length === 1
            ? $decoded[0]
            : (($decoded[0] & 0b00111111) << 2) | ($decoded[1] >> 6) | (($decoded[1] & 0b00111111) << 8);

        $decodedCount = count($decoded);

        // 32/33 bytes public + 2 bytes checksum + prefix
        $isPublicKey = in_array($decodedCount, [34 + $ss58Length, 35 + $ss58Length]);

        $length = $decodedCount - ($isPublicKey ? 2 : 1);

        // calculates the hash and do the checksum byte checks
        $hash = HexConverter::hexToBytes(bin2hex(sodium_crypto_generichash(
            hex2bin(self::CONTEXT . HexConverter::bytesToHex(array_slice($decoded, 0, $length))),
            '',
            64
        )));

        $isValid = ($decoded[0] & 0b10000000) === 0 && !in_array($decoded[0], [46, 47], true) && (
            $isPublicKey
                ? $decoded[$decodedCount - 2] === $hash[0] && $decoded[$decodedCount - 1] === $hash[1]
                : $decoded[$decodedCount - 1] === $hash[0]
        );

        return [$isValid, $length, $ss58Length, $ss58Decoded];
    }

    public static function isValidAddress(string $address): bool
    {
        try {
            self::encode(self::decode($address));

            return true;
        } catch (Exception) {
            return false;
        }
    }

    /**
     * @param string|array $key
     * @param int $ss58Format
     * @return string
     * @throws SodiumException
     */
    public static function encode(string|array $key, int $ss58Format = self::ENJIN_PREFIX): string
    {
        if ($ss58Format < 0 || $ss58Format > 16383 || in_array($ss58Format, [46, 47], true)) {
            throw new Exception('SS58 format out of range');
        }

        $u8a = self::decode($key);

        if (!in_array(count($u8a), self::ALLOWED_DECODED_LENGTHS)) {
            throw new Exception(sprintf(
                'Expected a valid key to convert, with length %s',
                implode(', ', self::ALLOWED_DECODED_LENGTHS)
            ));
        }

        $prefixBytes = $ss58Format < 64
            ? [$ss58Format]
            : [
                (($ss58Format & 0b0000000011111100) >> 2) | 0b01000000,
                ($ss58Format >> 8) | (($ss58Format & 0b0000000000000011) << 6),
            ];

        $input = array_merge($prefixBytes, $u8a);
        $hash = HexConverter::hexToBytes(bin2hex(sodium_crypto_generichash(
            hex2bin(self::CONTEXT . HexConverter::bytesToHex($input)),
            '',
            64
        )));

        $remove = in_array(count($u8a), [32, 33]) ? 2 : 1;
        $subarray = array_slice($hash, 0, $remove);
        $final = array_merge($input, $subarray);

        return (new Base58(['characters' => Base58::BITCOIN]))->encode(hex2bin(HexConverter::bytesToHex($final)));
    }

    public static function isValidPublicKey(string $key): bool
    {
        try {
            return strtolower($key) === strtolower((string) self::getPublicKey(self::encode($key)));
        } catch (Exception) {
            return false;
        }
    }
}
