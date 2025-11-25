<?php

use Osama\LaravelEnums\Tests\Enums\SimpleEnum;

it('can wrap an enum instance', function () {
    $enum = SimpleEnum::FIRST;
    $wrapped = SimpleEnum::wrap($enum);

    expect($wrapped)->toBe($enum);
    expect($wrapped)->toBeInstanceOf(SimpleEnum::class);
});

it('can wrap a string value to enum', function () {
    $wrapped = SimpleEnum::wrap('first');

    expect($wrapped)->toBe(SimpleEnum::FIRST);
    expect($wrapped)->toBeInstanceOf(SimpleEnum::class);
});

it('returns null when wrapping null value', function () {
    $wrapped = SimpleEnum::wrap(null);

    expect($wrapped)->toBeNull();
});

it('returns null when wrapping empty string', function () {
    $wrapped = SimpleEnum::wrap('');

    expect($wrapped)->toBeNull();
});

it('throws exception when wrapping invalid value in strict mode', function () {
    expect(fn () => SimpleEnum::wrap('invalid', true))
        ->toThrow(ValueError::class);
});

it('returns null when wrapping invalid value in non-strict mode', function () {
    $wrapped = SimpleEnum::wrap('invalid', false);

    expect($wrapped)->toBeNull();
});

