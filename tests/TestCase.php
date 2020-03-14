<?php

namespace benhorvath\PlanyoLaravel\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use benhorvath\PlanyoLaravel\PlanyoLaravelServiceProvider;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Contracts\Debug\ExceptionHandler;


abstract class TestCase extends OrchestraTestCase
{
    /**
     * Stores the history of HTTP transactions.
     *
     * @var array
     */
    protected static $httpHistoryContainer;

    /**
     * Stores a log of exceptions.
     *
     * @var array
     */
    protected static $exceptionLog;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PlanyoLaravelServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
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

    /**
     * Setup mocking of HTTP request handler.
     *
     * @param  \GuzzleHttp\Handler\MockHandler $mockHandler
     *
     * @return void
     */
    protected function mockHttpClient(MockHandler $mockHandler)
    {
        self::$httpHistoryContainer = [];

        $history = Middleware::history(self::$httpHistoryContainer);

        $handlerStack = HandlerStack::create($mockHandler);

        $handlerStack->push($history);

        $httpClient = new Client(['handler' => $handlerStack]);

        Config::set('planyo.httpClient', $httpClient);

        $this->app->bind('httpClient', function($app) {
            return Config::get('planyo.httpClient');
        });
    }

    /**
     * Setup mocking of exception handler.
     *
     * @return void
     */
    protected function mockExceptionHandler()
    {
        self::$exceptionLog = [];

        $mockExceptionHandler = new MockExceptionHandler(self::$exceptionLog);

        Config::set('planyo.mockExceptionHandler', $mockExceptionHandler);

        $this->app->bind(ExceptionHandler::class, function($app) {
            return Config::get('planyo.mockExceptionHandler');
        });
    }
}
