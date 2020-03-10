<?php

namespace Tschope\Finnhubio;

use Illuminate\Support\ServiceProvider;

class FinnhubioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // config
        $this->publishes([
            __DIR__.'/config/finnhubio.php' => config_path('finnhubio.php'),
        ], 'config');
    }
}
