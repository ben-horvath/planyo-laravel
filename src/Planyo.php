<?php

namespace benhorvath\PlanyoLaravel;

class Planyo
{
    public function __construct(
        $key,
        $site_id,
        $bookable_days
    )
    {
        $this->site_id = $site_id;
        $this->bookable_days = $bookable_days;
        $this->planyoAPI = new PlanyoAPI($key, $site_id, $bookable_days);
    }

    public function isWorking()
    {
        return $this->planyoAPI->isWorking();
    }
}
