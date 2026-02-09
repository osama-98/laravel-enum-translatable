<?php

use Osama\LaravelEnums\Tests\Enums\PatternEnum;
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

    expect($random)->toBeInstanceOf(SimpleEnum::class)
        ->and(SimpleEnum::values())->toContain($random->value);
});

it('can get a random enum value', function () {
    $randomValue = SimpleEnum::randomValue();

    expect(SimpleEnum::values())->toContain($randomValue);
});

it('can get random case excluding specific values', function () {
    $random = SimpleEnum::randomCase(SimpleEnum::FIRST);

    expect($random)->not->toBe(SimpleEnum::FIRST)
        ->and($random)->toBeInstanceOf(SimpleEnum::class);
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

    expect($random)->not->toBe(SimpleEnum::FIRST)
        ->and($random)->toBeInstanceOf(SimpleEnum::class);
});

it('can get only specific enum cases', function () {
    $cases = SimpleEnum::only([SimpleEnum::FIRST, SimpleEnum::SECOND]);

    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(SimpleEnum::FIRST)
        ->and($cases)->toContain(SimpleEnum::SECOND)
        ->and($cases)->not->toContain(SimpleEnum::THIRD);
});

it('can get only specific enum cases using string values', function () {
    $cases = SimpleEnum::only(['first', 'second']);

    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(SimpleEnum::FIRST)
        ->and($cases)->toContain(SimpleEnum::SECOND)
        ->and($cases)->not->toContain(SimpleEnum::THIRD);
});

it('can get enum cases except specific values', function () {
    $cases = SimpleEnum::except([SimpleEnum::THIRD]);

    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(SimpleEnum::FIRST)
        ->and($cases)->toContain(SimpleEnum::SECOND)
        ->and($cases)->not->toContain(SimpleEnum::THIRD);
});

it('can get enum cases except specific string values', function () {
    $cases = SimpleEnum::except(['third']);

    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(SimpleEnum::FIRST)
        ->and($cases)->toContain(SimpleEnum::SECOND)
        ->and($cases)->not->toContain(SimpleEnum::THIRD);
});

it('can get enum cases except multiple values', function () {
    $cases = SimpleEnum::except([SimpleEnum::FIRST, SimpleEnum::SECOND]);

    expect($cases)->toHaveCount(1)
        ->and($cases)->toContain(SimpleEnum::THIRD)
        ->and($cases)->not->toContain(SimpleEnum::FIRST)
        ->and($cases)->not->toContain(SimpleEnum::SECOND);
});

it('can match cases with prefix pattern', function () {
    $cases = PatternEnum::matching('active_*');

    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(PatternEnum::ACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::ACTIVE_ADMIN);
});

it('can match cases with suffix pattern', function () {
    $cases = PatternEnum::matching('*_admin');

    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(PatternEnum::ACTIVE_ADMIN)
        ->and($cases)->toContain(PatternEnum::INACTIVE_ADMIN);
});

it('can match cases with contains pattern', function () {
    $cases = PatternEnum::matching('*_user*');

    expect($cases)->toHaveCount(3)
        ->and($cases)->toContain(PatternEnum::ACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::INACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::PENDING_USER);
});

it('can match cases with exact value', function () {
    $cases = PatternEnum::matching('active_user');

    expect($cases)->toHaveCount(1)
        ->and($cases)->toContain(PatternEnum::ACTIVE_USER);
});

it('returns empty array when no cases match pattern', function () {
    $cases = PatternEnum::matching('nonexistent_*');

    expect($cases)->toBeEmpty();
});

it('matches cases case-insensitively', function () {
    $cases = PatternEnum::matching('ACTIVE_*');

    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(PatternEnum::ACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::ACTIVE_ADMIN);
});

it('can get cases not matching a pattern', function () {
    $cases = PatternEnum::notMatching('active_*');

    expect($cases)->toHaveCount(3)
        ->and($cases)->toContain(PatternEnum::INACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::INACTIVE_ADMIN)
        ->and($cases)->toContain(PatternEnum::PENDING_USER);
});

it('can get cases not matching a prefix pattern', function () {
    $cases = PatternEnum::notMatching('*_admin');

    expect($cases)->toHaveCount(3)
        ->and($cases)->toContain(PatternEnum::ACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::INACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::PENDING_USER);
});

it('can get cases starting with a prefix', function () {
    $cases = PatternEnum::startsWith('active_');

    expect($cases)->toHaveCount(2)
        ->and($cases)->toContain(PatternEnum::ACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::ACTIVE_ADMIN);
});

it('can get cases ending with a suffix', function () {
    $cases = PatternEnum::endsWith('_user');

    expect($cases)->toHaveCount(3)
        ->and($cases)->toContain(PatternEnum::ACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::INACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::PENDING_USER);
});

it('can get cases containing a substring', function () {
    $cases = PatternEnum::contains('_user');

    expect($cases)->toHaveCount(3)
        ->and($cases)->toContain(PatternEnum::ACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::INACTIVE_USER)
        ->and($cases)->toContain(PatternEnum::PENDING_USER);
});
