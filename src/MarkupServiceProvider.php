<?php

namespace Veloxia\Markup;

use Veloxia\Markup\Markup;
use Illuminate\Support\ServiceProvider;

class MarkupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // load the views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'veloxia');

        if ($this->app->runningInConsole()) {

            // publish config
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('veloxia.php'),
            ], 'config');

            // publish views
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/veloxia'),
            ], 'views');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'veloxia');

        // Register the main class to use with the facade
        $this->app->singleton('markup', function () {
            return new Markup();
        });
    }
}
