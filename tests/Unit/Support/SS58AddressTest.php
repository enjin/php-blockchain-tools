<?php

declare(strict_types=1);

namespace Tests\Unit\Support;

use Enjin\BlockchainTools\Support\SS58Address;
use PHPUnit\Framework\TestCase;

class SS58AddressTest extends TestCase
{
    public function testIsSameAddress(): void
    {
        $address1 = 'efQD2b5HVGivrC5zSoy7PqvdVyLbgC1wTaDmudFrpiUhKcXLr';
        $address2 = 'efSq4thn6gvRGuaxtUQqQvXWWYGNJpBM2LVVDBRJwd8WztBjA';

        $this->assertTrue(SS58Address::isSameAddress($address1, $address1));
        $this->assertFalse(SS58Address::isSameAddress($address1, $address2));
    }

    public function testGetPublicKey(): void
    {
        $address = 'efQD2b5HVGivrC5zSoy7PqvdVyLbgC1wTaDmudFrpiUhKcXLr';

        $publicKey = SS58Address::getPublicKey($address);
        $this->assertNotNull($publicKey);
        $this->assertMatchesRegularExpression('/^0x[0-9a-fA-F]{64}$/', $publicKey);
    }

    public function testDecode(): void
    {
        $address = 'efQD2b5HVGivrC5zSoy7PqvdVyLbgC1wTaDmudFrpiUhKcXLr';

        $decoded = SS58Address::decode($address);
        $this->assertIsArray($decoded);
        $this->assertNotEmpty($decoded);
    }

    public function testEncode(): void
    {
        $publicKey = '0x2ed99d30d202c7af44cb4a5e396cf1a2031ac96b012be333c55e472aee728375';
        $encoded = SS58Address::encode($publicKey);

        $this->assertIsString($encoded);
        $this->assertNotEmpty($encoded);
    }

    public function testIsValidAddress(): void
    {
        $address = 'efQD2b5HVGivrC5zSoy7PqvdVyLbgC1wTaDmudFrpiUhKcXLr';

        $this->assertTrue(SS58Address::isValidAddress($address));
    }

    public function testIsInvalidAddress(): void
    {
        $address = 'invalid';

        $this->assertFalse(SS58Address::isValidAddress($address));
    }

    public function testIsValidPublicKey(): void
    {
        $publicKey = '0x2ed99d30d202c7af44cb4a5e396cf1a2031ac96b012be333c55e472aee728375';

        $this->assertTrue(SS58Address::isValidPublicKey($publicKey));
    }

    public function testIsInvalidPublicKey(): void
    {
        $publicKey = 'invalid';

        $this->assertFalse(SS58Address::isValidPublicKey($publicKey));
    }
}
