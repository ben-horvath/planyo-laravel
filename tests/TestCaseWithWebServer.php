<?php

namespace benhorvath\PlanyoLaravel\Tests;

use benhorvath\PlanyoLaravel\Tests\TestCase;
use donatj\MockWebServer\MockWebServer;

abstract class TestCaseWithWebServer extends TestCase
{
    use NeedsWebServer;
}
