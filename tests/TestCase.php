<?php

namespace Tests;

use Faker\Factory;
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
}
