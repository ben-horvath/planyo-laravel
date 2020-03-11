<?php

namespace benhorvath\PlanyoLaravel\Tests;

class ExampleUnitTest extends TestCaseWithWebServer
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $planyo = $this->app->make('planyo');

        $this->assertTrue($planyo->isWorking());
    }
}
