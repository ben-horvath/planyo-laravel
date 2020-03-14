<?php

namespace benhorvath\PlanyoLaravel;

class Planyo
{
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
     * Stores an instance of the API handler.
     *
     * @var PlanyoAPI
     */
    protected $planyoAPI;

    /**
     * Constructs a Planyo handler with the given configuration.
     *
     * @param string $site_id The ID of the Planyo site being managed.
     * @param integer $bookable_days The farthest day from now that is allowed to be booked.
     * @param PlanyoAPI $planyoAPI An instance of the API handler
     */
    public function __construct(
        $site_id,
        $bookable_days,
        PlanyoAPI $planyoAPI
    ) {
        $this->site_id = $site_id;
        $this->bookable_days = $bookable_days;
        $this->planyoAPI = $planyoAPI;
    }

    /**
     * Check if it can communicate with the Planyo API.
     *
     * @return bool
     */
    public function isWorking()
    {
        return $this->planyoAPI->isWorking();
    }
}
