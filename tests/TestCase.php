<?php

namespace Tests;

use Closure;
use Exception;
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
        $this->assertExceptionThrown(InvalidArgumentException::class, $expectedMessage, $callback);
    }

    protected function assertExceptionThrown(string $expectedException, string $expectedMessage, Closure $callback)
    {
        try {
            $callback();
            $this->fail('failed to throw expected: ' . $expectedException . ', with message: ' . $expectedMessage);
        } catch (Exception $e) {
            $this->assertInstanceOf($expectedException, $e);
            $this->assertEquals($expectedMessage, $e->getMessage());

            if (!($e instanceof $expectedException)) {
                throw $e;
            }
        }
    }
}
