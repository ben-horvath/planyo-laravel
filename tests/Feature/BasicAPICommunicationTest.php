<?php

namespace benhorvath\PlanyoLaravel\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class BasicAPICommunicationTest extends TestCase
{
    /**
     * Test the API handler's feature that checks if the communication
     * between the handler and Planyo's own API is working.
     * 
     * This test case test the handler for positive response from Planyo.
     * 
     * @test
     */
    public function testAPICommunicationPositive()
    {
        /* Arrange */
        $mockHandler = new MockHandler([
            new Response(200)
        ]);

        $this->mockHttpClient($mockHandler);

        $planyo = resolve('Planyo');


        /* Act */
        $isWorking = $planyo->isWorking();


        /* Assert */
        $this->assertTrue($isWorking);
    }

    /**
     * Test the API handler's feature that checks if the communication
     * between the handler and Planyo's own API is working.
     * 
     * This test case test the handler for negative response from Planyo.
     * 
     * @test
     */
    public function testAPICommunicationNegative()
    {
        /* Arrange */
        $mockHandler = new MockHandler([
            new Response(500)
        ]);

        $this->mockHttpClient($mockHandler);

        $planyo = resolve('Planyo');


        /* Act */
        $isWorking = $planyo->isWorking();


        /* Assert */
        $this->assertFalse($isWorking);
    }
}
