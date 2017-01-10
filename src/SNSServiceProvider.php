<?php

namespace NotificationChannels\AwsSns;

use Illuminate\Support\ServiceProvider;
use Aws\Sns\SnsClient;

class SNSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(SNSChannel::class)
            ->needs(SNSClient::class)
            ->give(function () {
                return $this->app->make('aws')->createClient('sns');
            }
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->register(\Aws\Laravel\AwsServiceProvider::class);
    }
}
