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

it('returns true when comparing enum instance with same enum', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->is(SimpleEnum::FIRST))->toBeTrue();
});

it('returns false when comparing enum instance with different enum', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->is(SimpleEnum::SECOND))->toBeFalse();
});

it('returns true when comparing enum instance with matching string value', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->is('first'))->toBeTrue();
});

it('returns false when comparing enum instance with non-matching string value', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->is('second'))->toBeFalse();
});

it('returns true when enum does not match different enum', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isNot(SimpleEnum::SECOND))->toBeTrue();
});

it('returns false when enum does not match same enum', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isNot(SimpleEnum::FIRST))->toBeFalse();
});

it('returns true when enum does not match different string value', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isNot('second'))->toBeTrue();
});

it('returns true when enum matches any of given enum values', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isAny([SimpleEnum::FIRST, SimpleEnum::SECOND]))->toBeTrue();
});

it('returns false when enum does not match any of given enum values', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isAny([SimpleEnum::SECOND, SimpleEnum::THIRD]))->toBeFalse();
});

it('returns true when enum matches any of given string values', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isAny(['first', 'second']))->toBeTrue();
});

it('returns false when enum does not match any of given string values', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isAny(['second', 'third']))->toBeFalse();
});

it('returns true when enum does not match any of given enum values', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isNotAny([SimpleEnum::SECOND, SimpleEnum::THIRD]))->toBeTrue();
});

it('returns false when enum matches any of given enum values', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isNotAny([SimpleEnum::FIRST, SimpleEnum::SECOND]))->toBeFalse();
});

it('returns true when enum does not match any of given string values', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isNotAny(['second', 'third']))->toBeTrue();
});

it('returns false when enum matches any of given string values', function () {
    $enum = SimpleEnum::FIRST;

    expect($enum->isNotAny(['first', 'second']))->toBeFalse();
});
