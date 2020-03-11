<?php

namespace benhorvath\PlanyoLaravel\Tests;

use donatj\MockWebServer\MockWebServer;

trait NeedsWebServer
{
    /** @var MockWebServer */
	protected static $server;

	public static function setUpBeforeClass(): void
    {
		self::$server = new MockWebServer();
		self::$server->start();
        putenv('PLANYO_HOST=' . self::$server->getServerRoot());
	}

    public static function tearDownAfterClass(): void
    {
		// stopping the web server during tear down allows us to reuse the port for later tests
		self::$server->stop();
	}
}
