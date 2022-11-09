<?php

namespace Victtech\Lottery;

use Illuminate\Support\ServiceProvider;
use Victtech\Lottery\Command\ClearLotteryRecord;

class LotteryServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'victtech');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'victtech');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/lottery.php', 'lottery');

        // Register the service the package provides.
        $this->app->singleton('lottery', function ($app) {
            return new Lottery($app['session'],$app['config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['lottery'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/lottery.php' => config_path('lottery.php'),
        ], 'lottery.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/victtech'),
        ], 'lottery.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/victtech'),
        ], 'lottery.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/victtech'),
        ], 'lottery.views');*/

        // Registering package commands.
         $this->commands([
             ClearLotteryRecord::class
         ]);
    }
}
