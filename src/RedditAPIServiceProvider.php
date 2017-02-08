<?php

namespace CodeWizz\RedditAPI;

use Illuminate\Support\ServiceProvider;

class RedditAPIServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/reddit-api.php' => config_path('reddit-api.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/reddit-api.php', 'reddit-api');
        
        $redditAPIConfig = config('reddit-api');

        $this->app->singleton('laravel-reddit-api', function () use($redditAPIConfig) {
            return new RedditAPI($redditAPIConfig['username'], $redditAPIConfig['password'], $redditAPIConfig['app_id'], $redditAPIConfig['app_secret'], $redditAPIConfig['endpoint_standard'], $redditAPIConfig['endpoint_oauth'], $redditAPIConfig['response_format']);
        });
    }
}
