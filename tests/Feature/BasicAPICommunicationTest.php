<?php

namespace benhorvath\PlanyoLaravel\Tests;

use donatj\MockWebServer\Response;

class BasicAPICommunicationTest extends TestCaseWithWebServer
{
    /**
     * Test the API handler's feature that checks if the communication
     * between the handler and Planyo's own API is working.
     * 
     * This test case test the handler for positive response from Planyo.
     *
     * @return void
     */
    public function testBasicAPICommunicationPositive()
    {
        $planyo = $this->app->make('planyo');

        self::$server->setResponseOfPath('/rest', new Response(''));

        $this->assertTrue($planyo->isWorking());
    }

    /**
     * Test the API handler's feature that checks if the communication
     * between the handler and Planyo's own API is working.
     * 
     * This test case test the handler for negative response from Planyo.
     *
     * @return void
     */
    public function testBasicAPICommunicationNegative()
    {
        $planyo = $this->app->make('planyo');

        self::$server->setResponseOfPath('/rest', new Response('', [], 404));

        $this->assertFalse($planyo->isWorking());
    }
}
