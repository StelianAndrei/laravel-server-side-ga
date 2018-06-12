<?php

namespace StelianAndrei\LaravelServerSideGA;

use Config;
use Illuminate\Support\ServiceProvider;
use StelianAndrei\LaravelServerSideGA\GoogleAnalytics;

class AnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $config = realpath(__DIR__ . '/../config/analytics.php');
        $this->mergeConfigFrom($config, 'analytics');
        $this->publishes([
            $config => config_path('analytics.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('StelianAndrei\LaravelServerSideGA\GoogleAnalytics', function () {
            // getting the config
            $providerConfig = [];
            if (Config::has('analytics')) {
                $providerConfig = Config::get('analytics');
            }

            // make provider instance
            $instance = new GoogleAnalytics($providerConfig);

            // return the provider instance
            return $instance;
        });
    }
}
