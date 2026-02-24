<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Osama\LaravelEnums\Tests\Enums\TestStatusEnum;

beforeEach(function () {
    // Set default locale for tests
    App::setLocale('en');
});

it('can get translation key for enum', function () {
    $key = TestStatusEnum::getTransKey();

    expect($key)->toBe('enums.test_statuses');
});

it('can get translation key for enum case', function () {
    $enum = TestStatusEnum::DRAFT;
    $key = $enum->transKey();

    expect($key)->toBe('enums.test_statuses.draft');
});

it('can translate enum value in current locale', function () {
    App::setLocale('en');
    $enum = TestStatusEnum::DRAFT;

    expect($enum->trans())->toBe('Draft');
});

it('can translate enum value in specific locale', function () {
    $enum = TestStatusEnum::DRAFT;

    expect($enum->trans('en'))->toBe('Draft')
        ->and($enum->trans('ar'))->toBe('مسودة')
        ->and($enum->trans('es'))->toBe('Borrador');
});

it('can get all translations for enum case', function () {
    $enum = TestStatusEnum::DRAFT;
    $allTranslations = $enum->allTrans();

    expect($allTranslations)->toBe([
        'en' => 'Draft',
        'ar' => 'مسودة',
        'es' => 'Borrador',
    ]);
});

it('can get enum as object with value and translated name', function () {
    App::setLocale('en');
    $enum = TestStatusEnum::DRAFT;
    $object = $enum->object();

    expect($object)->toBe([
        'value' => 'draft',
        'name' => 'Draft',
    ]);
});

it('can get all enum options as array with id and name', function () {
    App::setLocale('en');
    $options = TestStatusEnum::toArrayTrans();

    expect($options)->toBe([
        ['value' => 'draft', 'name' => 'Draft'],
        ['value' => 'pending', 'name' => 'Pending'],
        ['value' => 'published', 'name' => 'Published'],
    ]);
});

it('can get all enum options as collection with value and name', function () {
    App::setLocale('en');
    $collection = TestStatusEnum::toTransCollection();

    expect($collection)
        ->toBeInstanceOf(Collection::class)
        ->and($collection->all())->toBe([
            ['value' => 'draft', 'name' => 'Draft'],
            ['value' => 'pending', 'name' => 'Pending'],
            ['value' => 'published', 'name' => 'Published'],
        ]);
});

it('can get toArrayTrans in a specific locale', function () {
    expect(TestStatusEnum::toArrayTrans('en'))->toBe([
        ['value' => 'draft', 'name' => 'Draft'],
        ['value' => 'pending', 'name' => 'Pending'],
        ['value' => 'published', 'name' => 'Published'],
    ])
        ->and(TestStatusEnum::toArrayTrans('ar'))->toBe([
        ['value' => 'draft', 'name' => 'مسودة'],
        ['value' => 'pending', 'name' => 'قيد المراجعة'],
        ['value' => 'published', 'name' => 'منشور'],
    ])
        ->and(TestStatusEnum::toArrayTrans('es'))->toBe([
        ['value' => 'draft', 'name' => 'Borrador'],
        ['value' => 'pending', 'name' => 'Pendiente'],
        ['value' => 'published', 'name' => 'Publicado'],
    ]);
});

it('can get toTransCollection in a specific locale', function () {
    expect(TestStatusEnum::toTransCollection('ar'))
        ->toBeInstanceOf(Collection::class)
        ->and(TestStatusEnum::toTransCollection('ar')->all())->toBe([
            ['value' => 'draft', 'name' => 'مسودة'],
            ['value' => 'pending', 'name' => 'قيد المراجعة'],
            ['value' => 'published', 'name' => 'منشور'],
        ]);
});

it('returns translated names based on current locale', function () {
    App::setLocale('ar');
    $options = TestStatusEnum::toArrayTrans();

    expect($options)->toBe([
        ['value' => 'draft', 'name' => 'مسودة'],
        ['value' => 'pending', 'name' => 'قيد المراجعة'],
        ['value' => 'published', 'name' => 'منشور'],
    ]);
});

it('can get object with translated name in different locale', function () {
    $enum = TestStatusEnum::PENDING;

    App::setLocale('en');
    expect($enum->object()['name'])->toBe('Pending');

    App::setLocale('ar');
    expect($enum->object()['name'])->toBe('قيد المراجعة');

    App::setLocale('es');
    expect($enum->object()['name'])->toBe('Pendiente');
});

it('can get all translations for all enum cases', function () {
    $draft = TestStatusEnum::DRAFT;
    $pending = TestStatusEnum::PENDING;
    $published = TestStatusEnum::PUBLISHED;

    expect($draft->allTrans())
        ->toBe([
            'en' => 'Draft',
            'ar' => 'مسودة',
            'es' => 'Borrador',
        ])
        ->and($pending->allTrans())->toBe([
            'en' => 'Pending',
            'ar' => 'قيد المراجعة',
            'es' => 'Pendiente',
        ])
        ->and($published->allTrans())->toBe([
            'en' => 'Published',
            'ar' => 'منشور',
            'es' => 'Publicado',
        ]);
});
