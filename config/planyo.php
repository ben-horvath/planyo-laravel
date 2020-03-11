<?php

return [
    'key' => env('PLANYO_KEY'),
    'site_id' => env('PLANYO_SITE_ID'),
    'bookable_days' => env('BOOKABLE_DAYS', 30),
    'host' => env('PLANYO_HOST', 'http://www.planyo.com'),
    'endpoint' => env('PLANYO_ENDPOINT', 'rest'),
];
