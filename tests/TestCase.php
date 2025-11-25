<?php

namespace Osama\LaravelEnums\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Osama\LaravelEnums\LaravelEnumTranslatableServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Osama\\LaravelEnums\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelEnumTranslatableServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('laravel-enums.supported_locales', ['en', 'ar', 'es']);

        // Set up translation files path for testing
        $app->useLangPath(__DIR__.'/lang');
    }
}
