<?php

namespace App\Providers;

use App\Services\SunlightConnection;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LegislatorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('api', function() {
            return new SunlightConnection(
                getenv('API_KEY'),
                new Client(['base_uri' => getenv('BASE_URI')])
            );
        });
    }
}
