<?php

namespace NotificationChannels\AwsSns;

use Illuminate\Support\ServiceProvider;

class SNSServiceProvider extends ServiceProvider
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
        $this->app->register(\Aws\Laravel\AwsServiceProvider::class);
    }
}
