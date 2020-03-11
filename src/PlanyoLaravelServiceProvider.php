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
        $this->app->singleton('planyo', function() {
            return new Planyo(
                config('planyo.key'),
                config('planyo.site_id'),
                config('planyo.bookable_days')
            );
        });
    }
}
