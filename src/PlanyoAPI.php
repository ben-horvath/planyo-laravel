<?php

namespace benhorvath\PlanyoLaravel;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

class PlanyoAPI
{
    public function __construct(
        $key,
        $site_id,
        $bookable_days
    )
    {
        $this->client = new HttpClient();
        $this->key = $key;
        $this->site_id = $site_id;
        $this->bookable_days = $bookable_days;
    }

    public function isWorking()
    {
        $response = $this->callPlanyoAPI('api_test', null, true);

        if (
            !empty($response) &&
            $response->getStatusCode() == 200
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function callPlanyoAPI(
        $method,
        $params = null,
        $return_guzzle_response = false
    ) {
        if (empty($params)) {
            $params = [];
        }

        /* Make it easier to test by changing host based on environment */
        $host = getenv('PLANYO_HOST') ?: 'https://www.planyo.com';
        $endPoint = config('planyo.endpoint', '/rest');

        try {
            $response = $this->client->request('GET', $host . $endPoint, [
                'query' => array_merge(
                    [
                        'api_key' => $this->key,
                        'method' => $method
                    ],
                    $params
                )
            ]);
        } catch (GuzzleException $e) {
            report($e);
            return;
        }

        if ($return_guzzle_response) {
            return $response;
        }

        return json_decode($response->getBody()->getContents());
    }
}
