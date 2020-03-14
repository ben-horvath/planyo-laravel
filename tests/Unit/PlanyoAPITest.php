<?php

namespace benhorvath\PlanyoLaravel\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class PlanyoAPITest extends TestCase
{
    /**
     * Test request with only a method specified (no params)
     * 
     * Test if the handler sends the right request
     * when only the API method is specified without any parameters.
     * 
     * @test
     */
    public function callPlanyoAPISendsTheRightRequestWithMethodOnly()
    {
        /* Arrange */
        $mockHandler = new MockHandler([
            new Response(200)
        ]);

        $this->mockHttpClient($mockHandler);

        $planyoAPI = resolve('PlanyoAPI');


        /* Act */
        $planyoAPI->callPlanyoAPI('test');


        /* Assert */
        $query = self::$httpHistoryContainer[0]['request']->getUri()->getQuery();

        parse_str($query, $queryParams);

        $this->assertEquals('test', $queryParams['method']);
    }

    /**
     * Test request with a specified method and parameters
     * 
     * Test if the handler sends the right request
     * when the API method and the parameters are specified.
     * 
     * @test
     */
    public function callPlanyoAPISendsTheRightRequestWithParams()
    {
        /* Arrange */
        $mockHandler = new MockHandler([
            new Response(200)
        ]);

        $this->mockHttpClient($mockHandler);

        $planyoAPI = resolve('PlanyoAPI');


        /* Act */
        $planyoAPI->callPlanyoAPI(
            'test',
            [
                'param1' => 'first',
                'param2' => 'second'
            ]
        );


        /* Assert */
        $query = self::$httpHistoryContainer[0]['request']->getUri()->getQuery();

        parse_str($query, $queryParams);

        $this->assertEquals('test', $queryParams['method']);
        $this->assertEquals('first', $queryParams['param1']);
        $this->assertEquals('second', $queryParams['param2']);
    }

    /**
     * Test return value when Guzzle response is required
     * 
     * Test if the handler returns the right Guzzle Response object
     * when Guzzle Response type is required as a return value.
     * 
     * @test
     */
    public function callPlanyoAPIReturnsTheRightGuzzleResponse()
    {
        /* Arrange */
        $mockHandler = new MockHandler([
            new Response(200, [], 'Hello')
        ]);

        $this->mockHttpClient($mockHandler);

        $planyoAPI = resolve('PlanyoAPI');


        /* Act */
        $response = $planyoAPI->callPlanyoAPI('test', null, true);


        /* Assert */
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('Hello', $response->getBody());
    }

    /**
     * Test return value when no return type is required
     * 
     * Test if the handler returns the right response object
     * when no response type is specified for returning.
     * 
     * @test
     */
    public function callPlanyoAPIReturnsTheRightResponseBody()
    {
        /* Arrange */
        $mockHandler = new MockHandler([
            new Response(200, [], '{"greeting": "Hello there!"}')
        ]);

        $this->mockHttpClient($mockHandler);

        $planyoAPI = resolve('PlanyoAPI');


        /* Act */
        $response = $planyoAPI->callPlanyoAPI('test');


        /* Assert */
        $this->assertTrue(is_object($response));
        $this->assertEquals('Hello there!', $response->greeting);
    }

    /**
     * Test if errors are reported
     * 
     * Test if the handler reports an error upon errors during the request.
     * 
     * @test
     */
    public function callPlanyoAPIReportsErrors()
    {
        /* Arrange */
        $mockHandler = new MockHandler([
            new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        ]);

        $this->mockHttpClient($mockHandler);
        $this->mockExceptionHandler();

        $planyoAPI = resolve('PlanyoAPI');


        /* Act */
        $planyoAPI->callPlanyoAPI('test');


        /* Assert */
        $this->assertEquals(1, count(self::$exceptionLog));
        $this->assertInstanceOf(RequestException::class, self::$exceptionLog[0]);
        $this->assertEquals('Error Communicating with Server', self::$exceptionLog[0]->getMessage());
    }
}
