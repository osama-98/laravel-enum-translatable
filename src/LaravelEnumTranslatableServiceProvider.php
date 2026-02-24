<?php

namespace Osama\LaravelEnums;

use Illuminate\Support\ServiceProvider;
use Osama\LaravelEnums\Commands\MakeEnumCommand;

class LaravelEnumTranslatableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-enums.php', 'laravel-enums');
    }

    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/laravel-enums.php' => config_path('laravel-enums.php'),
        ], 'laravel-enums-config');

        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-enums.php',
            'laravel-enums'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeEnumCommand::class,
            ]);
        }
    }
}
