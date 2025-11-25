<?php

namespace Osama\LaravelEnums;

use Illuminate\Support\ServiceProvider;

class LaravelEnumTranslatableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-enums.php' => config_path('laravel-enums.php'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/lang/en/enums.php' => lang_path('en/enums.php'),
        ]);
    }
}
