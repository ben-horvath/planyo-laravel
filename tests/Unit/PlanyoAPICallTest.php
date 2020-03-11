<?php

namespace benhorvath\PlanyoLaravel\Tests;

use donatj\MockWebServer\Response;
use benhorvath\PlanyoLaravel\PlanyoAPI;

class PlanyoAPICallTest extends TestCaseWithWebServer
{
    /**
     * Test the callPlanyoAPI method of PlanyoAPI class.
     * 
     * This test case test the handler for positive response from Planyo.
     *
     * @return void
     */
    public function testCallPlanyoAPIPositive()
    {
        $planyoAPI = new PlanyoAPI(getenv('PLANYO_KEY'), getenv('PLANYO_SITE_ID'), getenv('BOOKABLE_DAYS'));

        self::$server->setResponseOfPath('/rest', new Response('response body'));

        $response = $planyoAPI->callPlanyoAPI('get_resource_usage', null, true);

        $this->assertEquals('response body', $response->getBody());
    }
}
