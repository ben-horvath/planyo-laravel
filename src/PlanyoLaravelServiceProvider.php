<?php

namespace benhorvath\PlanyoLaravel;

use Illuminate\Support\ServiceProvider;

class PlanyoLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/planyo.php' => config_path('planyo.php'),
        ]);
    }

    public function register()
    {
    }
}
