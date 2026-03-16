<?php

namespace Osama\LaravelEnums\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Osama\LaravelEnums\LaravelEnumTranslatableServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelEnumTranslatableServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('laravel-enums.supported_locales', ['en', 'ar', 'es']);

        // Set up translation files path for testing
        $app->useLangPath(__DIR__.'/lang');
    }
}
