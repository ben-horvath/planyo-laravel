<?php

namespace benhorvath\PlanyoLaravel;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as GuzzleClient;

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
        $this->app->bind('httpClient', function($app) {
            return new GuzzleClient();
        });

        $this->app->bind('PlanyoAPI', function($app) {
            return new PlanyoAPI(
                config('planyo.key'),
                config('planyo.site_id'),
                config('planyo.bookable_days')
            );
        });

        $this->app->bind('Planyo', function($app) {
            return new Planyo(
                config('planyo.site_id'),
                config('planyo.bookable_days'),
                $app->make('PlanyoAPI')
            );
        });
    }
}
