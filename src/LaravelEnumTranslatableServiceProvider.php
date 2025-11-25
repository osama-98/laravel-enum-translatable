<?php

namespace Osama\LaravelEnums;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Osama\LaravelEnums\Contracts\TranslationNamespaceResolverInterface;

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

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'enums');

        $this->app->singleton(
            abstract: TranslationNamespaceResolverInterface::class,
            concrete: fn (Application $app) => $app->make(config('laravel-enums.namespace_resolver'))
        );
    }
}
