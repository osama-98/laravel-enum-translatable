<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::deleteDirectory($this->app->path('Enums'));
});

afterEach(function () {
    File::deleteDirectory($this->app->path('Enums'));
});

it('generates a string backed enum by default', function () {
    $this->artisan('make:enum', ['name' => 'UserStatus'])
        ->assertExitCode(0);

    $contents = file_get_contents($this->app->path('Enums/UserStatusEnum.php'));

    expect($contents)
        ->toContain('enum UserStatusEnum: string')
        ->toContain('declare(strict_types=1)');
});

it('generates an integer backed enum with --int', function () {
    $this->artisan('make:enum', ['name' => 'UserStatus', '--int' => true])
        ->assertExitCode(0);

    $contents = file_get_contents($this->app->path('Enums/UserStatusEnum.php'));

    expect($contents)->toContain('enum UserStatusEnum: int');
});

it('includes EnumTranslatable by default', function () {
    $this->artisan('make:enum', ['name' => 'UserStatus'])
        ->assertExitCode(0);

    $contents = file_get_contents($this->app->path('Enums/UserStatusEnum.php'));

    expect($contents)
        ->toContain('use Osama\LaravelEnums\Concerns\EnumTranslatable;')
        ->toContain('use EnumTranslatable;')
        ->not->toContain('EnumArrayable')
        ->not->toContain('EnumWrappable');
});

it('uses EnumArrayable instead of EnumTranslatable with --arrayable', function () {
    $this->artisan('make:enum', ['name' => 'UserStatus', '--arrayable' => true])
        ->assertExitCode(0);

    $contents = file_get_contents($this->app->path('Enums/UserStatusEnum.php'));

    expect($contents)
        ->toContain('use Osama\LaravelEnums\Concerns\EnumArrayable;')
        ->toContain('use EnumArrayable;')
        ->not->toContain('EnumTranslatable')
        ->not->toContain('EnumWrappable');
});

it('uses EnumWrappable instead of EnumTranslatable with --wrappable', function () {
    $this->artisan('make:enum', ['name' => 'UserStatus', '--wrappable' => true])
        ->assertExitCode(0);

    $contents = file_get_contents($this->app->path('Enums/UserStatusEnum.php'));

    expect($contents)
        ->toContain('use Osama\LaravelEnums\Concerns\EnumWrappable;')
        ->toContain('use EnumWrappable;')
        ->not->toContain('EnumTranslatable')
        ->not->toContain('EnumArrayable');
});

it('uses EnumArrayable alone even when --wrappable is also passed since EnumArrayable includes EnumWrappable', function () {
    $this->artisan('make:enum', ['name' => 'UserStatus', '--arrayable' => true, '--wrappable' => true])
        ->assertExitCode(0);

    $contents = file_get_contents($this->app->path('Enums/UserStatusEnum.php'));

    expect($contents)
        ->toContain('use Osama\LaravelEnums\Concerns\EnumArrayable;')
        ->toContain('use EnumArrayable;')
        ->not->toContain('EnumWrappable')
        ->not->toContain('EnumTranslatable');
});

it('prompts for name when not provided', function () {
    $this->artisan('make:enum')
        ->expectsQuestion('What should the enum be named?', 'UserStatus')
        ->assertExitCode(0);

    expect(file_exists($this->app->path('Enums/UserStatusEnum.php')))->toBeTrue();
});

it('appends Enum suffix when not provided', function () {
    $this->artisan('make:enum', ['name' => 'Order'])
        ->assertExitCode(0);

    expect(file_exists($this->app->path('Enums/OrderEnum.php')))->toBeTrue();
});

it('does not double-append Enum suffix', function () {
    $this->artisan('make:enum', ['name' => 'OrderEnum'])
        ->assertExitCode(0);

    expect(file_exists($this->app->path('Enums/OrderEnum.php')))->toBeTrue()
        ->and(file_exists($this->app->path('Enums/OrderEnumEnum.php')))->toBeFalse();
});

it('places the generated file in the Enums namespace', function () {
    $this->artisan('make:enum', ['name' => 'PaymentStatus'])
        ->assertExitCode(0);

    $contents = file_get_contents($this->app->path('Enums/PaymentStatusEnum.php'));

    expect($contents)->toContain('namespace App\Enums');
});

it('supports nested paths', function () {
    $this->artisan('make:enum', ['name' => 'Admin/UserStatus'])
        ->assertExitCode(0);

    $contents = file_get_contents($this->app->path('Enums/Admin/UserStatusEnum.php'));

    expect($contents)
        ->toContain('namespace App\Enums\Admin')
        ->toContain('enum UserStatusEnum: string');
});
