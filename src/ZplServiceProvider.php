<?php

namespace IMusic\ZplBuilder;

use Illuminate\Support\ServiceProvider;

class BuilderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'svg-to-zpl');
    }
}
