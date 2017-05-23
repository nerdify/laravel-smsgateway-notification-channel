<?php

namespace Nerdify\SmsGateway;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class SmsGatewayServiceProvider extends ServiceProvider
{
    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(SmsGatewayChannel::class)
            ->needs(SmsGatewayClient::class)
            ->give(function () {
                $config = $this->app['config']['services.smsgateway'];

                return new SmsGatewayClient(
                    new HttpClient,
                    $config['email'],
                    $config['password'],
                    $config['device']
                );
            });
    }
}
