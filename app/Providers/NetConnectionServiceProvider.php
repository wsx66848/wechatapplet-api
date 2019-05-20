<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NetConnection;

class NetConnectionServiceProvider extends ServiceProvider
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
        $this->app->bind(NetConnection\HttpInterface::class, function($app) {
            return new NetConnection\Curl($app['config']['applet.remote_url']);
        });
    }
}
