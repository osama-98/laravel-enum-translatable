<?php

use Osama\LaravelEnums\Tests\Enums\SimpleEnum;

it('can get all enum case names', function () {
    $names = SimpleEnum::names();

    expect($names)->toBe(['FIRST', 'SECOND', 'THIRD']);
});

it('can get all enum values', function () {
    $values = SimpleEnum::values();

    expect($values)->toBe(['first', 'second', 'third']);
});

it('can convert enum to array', function () {
    $array = SimpleEnum::toArray();

    expect($array)->toBe([
        'first' => 'FIRST',
        'second' => 'SECOND',
        'third' => 'THIRD',
    ]);
});

it('can get a random enum case', function () {
    $random = SimpleEnum::randomCase();

    expect($random)->toBeInstanceOf(SimpleEnum::class);
    expect(SimpleEnum::values())->toContain($random->value);
});

it('can get a random enum value', function () {
    $randomValue = SimpleEnum::randomValue();

    expect(SimpleEnum::values())->toContain($randomValue);
});

it('can get random case excluding specific values', function () {
    $random = SimpleEnum::randomCase(SimpleEnum::FIRST);

    expect($random)->not->toBe(SimpleEnum::FIRST);
    expect($random)->toBeInstanceOf(SimpleEnum::class);
});

it('can get random case excluding array of values', function () {
    $random = SimpleEnum::randomCase([SimpleEnum::FIRST, SimpleEnum::SECOND]);

    expect($random)->toBe(SimpleEnum::THIRD);
});

it('can get random value excluding specific values', function () {
    $randomValue = SimpleEnum::randomValue([SimpleEnum::FIRST, SimpleEnum::SECOND]);

    expect($randomValue)->toBe('third');
});

it('can get random case excluding string values', function () {
    $random = SimpleEnum::randomCase('first');

    expect($random)->not->toBe(SimpleEnum::FIRST);
    expect($random)->toBeInstanceOf(SimpleEnum::class);
});

