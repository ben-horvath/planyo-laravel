<?php

namespace benhorvath\PlanyoLaravel;

use GuzzleHttp\Exception\GuzzleException;

class PlanyoAPI
{
    /**
     * Stores the exceptions.
     *
     * @var GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * Stores the Planyo API key.
     *
     * @var string
     */
    protected $key;

    /**
     * Stores the ID of the Planyo site being managed.
     *
     * @var string
     */
    protected $site_id;

    /**
     * Stores the days count that defines the farthest day from now
     * that is allowed to be booked.
     *
     * @var integer
     */
    protected $bookable_days;

    /**
     * Constructs an API handler with the given configuration.
     *
     * @param string $key The Planyo API key.
     * @param string $site_id The ID of the Planyo site being managed.
     * @param integer $bookable_days The farthest day from now that is allowed to be booked.
     */
    public function __construct(
        $key,
        $site_id,
        $bookable_days
    )
    {
        $this->httpClient = resolve('httpClient');
        $this->key = $key;
        $this->site_id = $site_id;
        $this->bookable_days = $bookable_days;
    }

    /**
     * Check if it can communicate with the Planyo API.
     *
     * @return bool
     */
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

    /**
     * Check if it can communicate with the Planyo API.
     *
     * @param string $method The method to be called in the Planyo API.
     * @param array|null $params The associative array of parameters to the specified API method.
     * @param bool $return_guzzle_response Indicates if the return value should be returned in a Guzzle Response object.
     * 
     * @return mixed
     */
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
            $response = $this->httpClient->request('GET', $host . $endPoint, [
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
