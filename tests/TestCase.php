<?php

namespace benhorvath\PlanyoLaravel\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use benhorvath\PlanyoLaravel\PlanyoLaravelServiceProvider;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\Config;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            PlanyoLaravelServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        /* Get environment variables from .env file in tests */
        if (file_exists(dirname(__DIR__) . '/.env')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
            $dotenv->load();
        }

        /* Populate config with the environment variables */
        Config::set('planyo.key', getenv('PLANYO_KEY'));
        Config::set('planyo.site_id', getenv('PLANYO_SITE_ID'));
        Config::set('planyo.bookable_days', getenv('BOOKABLE_DAYS'));
        Config::set('planyo.host', getenv('PLANYO_HOST'));
        Config::set('planyo.endpoint', getenv('PLANYO_ENDPOINT') ?: '/rest');
    }
}
