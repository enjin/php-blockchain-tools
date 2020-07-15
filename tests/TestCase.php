<?php

namespace Tests;

use Closure;
use Faker\Factory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Tests\Support\FakerBlockchainProvider;

class TestCase extends BaseTestCase
{
    private static $faker;

    protected function faker()
    {
        if (!self::$faker) {
            $faker = Factory::create();
            $faker->addProvider(new FakerBlockchainProvider($faker));
            self::$faker = $faker;
        }

        return self::$faker;
    }

    protected function assertInvalidArgumentException(string $expectedMessage, Closure $callback)
    {
        try {
            $callback();
            $this->fail('failed to throw expected InvalidArgumentException');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals($expectedMessage, $e->getMessage());
        }
    }
}
