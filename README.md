<div align="center">

![Laravel Enum Translatable](.github/logo.svg)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/osama-98/laravel-enum-translatable.svg?style=flat-square)](https://packagist.org/packages/osama-98/laravel-enum-translatable)
[![Total Downloads](https://img.shields.io/packagist/dt/osama-98/laravel-enum-translatable.svg)](https://packagist.org/packages/osama-98/laravel-enum-translatable)
[![License](https://img.shields.io/packagist/l/osama-98/laravel-enum-translatable.svg?style=flat-square)](https://packagist.org/packages/osama-98/laravel-enum-translatable)

</div>

# Laravel Enum Translatable

A Laravel package that extends PHP 8.2 backed enums with first-class translation support, fluent array helpers, and safe comparison utilities — all through composable traits.

**References:** [Medium Article](https://masteryoflaravel.medium.com/stop-hardcoding-translations-the-revolutionary-way-to-build-multilingual-laravel-apps-with-bf383533b8b8) · [Laravel News](https://laravel-news.com/translatable-enums)

---

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [Available Traits](#available-traits)
- [Generating Enums](#generating-enums)
- [Usage](#usage)
  - [Translation Key Convention](#translation-key-convention)
  - [EnumTranslatable](#enumtranslatable)
  - [EnumArrayable](#enumarrayable)
  - [EnumWrappable](#enumwrappable)
- [Real-World Examples](#real-world-examples)
- [Testing](#testing)
- [Changelog](#changelog)
- [Credits](#credits)
- [License](#license)

---

## Requirements

- PHP 8.2 or higher
- Laravel 11.0 or higher

---

## Installation

Install the package via Composer:

```bash
composer require osama-98/laravel-enum-translatable
```

---

## Quick Start

**Step 1.** Generate an enum using the Artisan command:

```bash
php artisan make:enum OrderStatus
```

**Step 2.** Define your cases and apply the trait:

```php
enum OrderStatusEnum: string
{
    use EnumTranslatable;

    case PENDING   = 'pending';
    case SHIPPED   = 'shipped';
    case DELIVERED = 'delivered';
}
```

**Step 3.** Add translation entries in `lang/en/enums.php`:

```php
return [
    'order_statuses' => [
        'pending'   => 'Pending',
        'shipped'   => 'Shipped',
        'delivered' => 'Delivered',
    ],
];
```

**Step 4.** Use the enum in your application:

```php
OrderStatusEnum::PENDING->trans();      // 'Pending'
OrderStatusEnum::PENDING->trans('ar');  // 'قيد الانتظار'
OrderStatusEnum::toArrayTrans();        // [['value' => 'pending', 'name' => 'Pending'], ...]
```

---

## Configuration

Publish the configuration file to customise supported locales and modular support:

```bash
php artisan vendor:publish --tag="laravel-enums-config"
```

```php
// config/laravel-enums.php

return [

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    | The locales that allTrans() will return translations for.
    */
    'supported_locales' => ['en'],

    /*
    |--------------------------------------------------------------------------
    | Modular Support
    |--------------------------------------------------------------------------
    | Enable this if you use a module system such as nWidart/laravel-modules.
    | Translations will be loaded from each module's namespace automatically.
    */
    'modular_enabled' => false,

    /*
    |--------------------------------------------------------------------------
    | Namespace Resolver
    |--------------------------------------------------------------------------
    | The class responsible for resolving a module's translation namespace.
    | Extend TranslationNamespaceResolver to customise the resolution logic.
    */
    'namespace_resolver' => \Osama\LaravelEnums\TranslationNamespaceResolver::class,

];
```

---

## Available Traits

The package provides three traits that compose on top of one another:

```
EnumTranslatable
└── EnumArrayable
    └── EnumWrappable
```

| Trait | Intended Use |
|---|---|
| `EnumTranslatable` | Enums that require translated labels. Includes all traits below. |
| `EnumArrayable` | Enums used for filtering or listing, without translation. |
| `EnumWrappable` | Enums that only need comparison and safe-casting helpers. |

---

## Generating Enums

Use the `make:enum` Artisan command to scaffold a new enum class:

```bash
# String-backed with EnumTranslatable (default)
php artisan make:enum OrderStatus

# Integer-backed
php artisan make:enum OrderStatus --int

# With EnumArrayable
php artisan make:enum OrderStatus --arrayable

# With EnumWrappable
php artisan make:enum OrderStatus --wrappable
```

> **Note:** The `--arrayable` flag already includes `EnumWrappable` internally. There is no need to combine both flags.

Generated files are placed in `app/Enums/`. Nested namespaces are supported using `/`:

```bash
php artisan make:enum Admin/UserStatus
# Generates: app/Enums/Admin/UserStatusEnum.php
# Namespace:  App\Enums\Admin
```

The `Enum` suffix is appended automatically if it is not included in the provided name.

---

## Usage

All examples in this section use the following enum definition:

```php
<?php

namespace App\Enums;

use Osama\LaravelEnums\Concerns\EnumTranslatable;

enum CourseStatusEnum: string
{
    use EnumTranslatable;

    case DRAFT     = 'draft';
    case PENDING   = 'pending';
    case PUBLISHED = 'published';
}
```

### Translation Key Convention

The translation key is derived automatically from the enum class name by applying the following rules:

1. Strip the `Enum` suffix
2. Convert to `snake_case`
3. Pluralise
4. Nest under the `enums` key

```
CourseStatusEnum  =>  enums.course_statuses
```

Create one `enums.php` translation file per locale inside your `lang/` directory:

```
lang/
├── en/
│   └── enums.php
└── ar/
    └── enums.php
```

```php
// lang/en/enums.php
return [
    'course_statuses' => [
        'draft'                => 'Draft',
        'draft_description'    => ':name is currently in draft mode.',
        'pending'              => 'Pending',
        'pending_description'  => ':name is currently pending review.',
        'published'            => 'Published',
        'published_description' => 'Your post has been published.',
    ],
];

// lang/ar/enums.php
return [
    'course_statuses' => [
        'draft'                => 'مسودة',
        'draft_description'    => ':name في وضع المسودة حاليًا.',
        'pending'              => 'قيد المراجعة',
        'pending_description'  => ':name قيد المراجعة حاليًا.',
        'published'            => 'منشور',
        'published_description' => 'تم نشر المنشور.',
    ],
];
```

---

### EnumTranslatable

#### `trans(?string $locale = null, ?string $context = null, array $replace = []): string`

Returns the translated label for the current case. Defaults to the application locale. Falls back to the raw enum value if no translation is found.

```php
$status = CourseStatusEnum::DRAFT;

$status->trans();     // 'Draft'   (current application locale)
$status->trans('ar'); // 'مسودة'
$status->trans('en'); // 'Draft'
```

The optional `$context` parameter appends a suffix to the translation key, enabling multiple label variants per case:

```php
CourseStatusEnum::PUBLISHED->trans(context: 'description');
// 'Your post has been published.'
```

The optional `$replace` parameter passes replacement variables into the translation string, identical to Laravel's `__()` helper:

```php
CourseStatusEnum::DRAFT->trans(context: 'description', replace: ['name' => 'Course A']);
// 'Course A is currently in draft mode.'
```

#### `allTrans(): array`

Returns translations for all locales defined in the `supported_locales` configuration option.

```php
CourseStatusEnum::DRAFT->allTrans();
// ['en' => 'Draft', 'ar' => 'مسودة']
```

#### `toArrayTrans(?string $locale = null): array`

Returns all cases as an array of `['value', 'name']` pairs. Uses the current application locale when `$locale` is `null`.

```php
CourseStatusEnum::toArrayTrans();     // current locale
CourseStatusEnum::toArrayTrans('ar'); // Arabic
CourseStatusEnum::toArrayTrans('en'); // English

// [
//     ['value' => 'draft',     'name' => 'Draft'],
//     ['value' => 'pending',   'name' => 'Pending'],
//     ['value' => 'published', 'name' => 'Published'],
// ]
```

#### `toTransCollection(?string $locale = null): Collection`

Identical to `toArrayTrans()` but returns a Laravel `Collection`.

```php
CourseStatusEnum::toTransCollection('ar');

// Collection([
//     ['value' => 'draft',     'name' => 'مسودة'],
//     ['value' => 'pending',   'name' => 'قيد المراجعة'],
//     ['value' => 'published', 'name' => 'منشور'],
// ])
```

#### `object(): array`

Returns the current case as a `['value', 'name']` pair using the current locale. Suitable for use in API responses.

```php
CourseStatusEnum::DRAFT->object();
// ['value' => 'draft', 'name' => 'Draft']
```

#### `transKey(): string`

Returns the full translation key for the current case.

```php
CourseStatusEnum::DRAFT->transKey();
// 'enums.course_statuses.draft'
```

#### `getTransKey(): string`

Returns the translation key for the enum class, without a specific case appended.

```php
CourseStatusEnum::getTransKey();
// 'enums.course_statuses'
```

---

### EnumArrayable

#### `names(): array` · `values(): array` · `toArray(): array`

```php
CourseStatusEnum::names();   // ['DRAFT', 'PENDING', 'PUBLISHED']
CourseStatusEnum::values();  // ['draft', 'pending', 'published']
CourseStatusEnum::toArray(); // ['draft' => 'DRAFT', 'pending' => 'PENDING', 'published' => 'PUBLISHED']
```

#### `toCollection(): Collection`

Identical to `toArray()` but returns a Laravel `Collection`.

```php
CourseStatusEnum::toCollection();
// Collection(['draft' => 'DRAFT', 'pending' => 'PENDING', 'published' => 'PUBLISHED'])

CourseStatusEnum::toCollection()->keys();   // ['draft', 'pending', 'published']
CourseStatusEnum::toCollection()->values(); // ['DRAFT', 'PENDING', 'PUBLISHED']
```

#### `only(array $values): array` · `except(array $values): array`

Filter cases by value. Accepts raw string values or enum instances.

```php
CourseStatusEnum::only(['draft', 'pending']);
// [CourseStatusEnum::DRAFT, CourseStatusEnum::PENDING]

CourseStatusEnum::except([CourseStatusEnum::PUBLISHED]);
// [CourseStatusEnum::DRAFT, CourseStatusEnum::PENDING]
```

#### `randomCase(): self` · `randomValue(): string`

Returns a random case or raw value. Accepts an optional exclusion list.

```php
CourseStatusEnum::randomCase();  // e.g. CourseStatusEnum::PENDING
CourseStatusEnum::randomValue(); // e.g. 'pending'

CourseStatusEnum::randomCase(except: CourseStatusEnum::DRAFT);
CourseStatusEnum::randomValue(except: ['draft', 'pending']); // always returns 'published'
```

#### `matching(string $pattern): array` · `notMatching(string $pattern): array`

Filter cases using a wildcard pattern. Matching is case-insensitive; `*` matches any sequence of characters.

```php
CourseStatusEnum::matching('*ed');    // [PENDING, PUBLISHED]
CourseStatusEnum::notMatching('*ed'); // [DRAFT]
```

The following convenience methods are also available:

```php
CourseStatusEnum::startsWith('p');  // [PENDING, PUBLISHED]
CourseStatusEnum::endsWith('ed');   // [PENDING, PUBLISHED]
CourseStatusEnum::contains('ish');  // [PUBLISHED]
```

---

### EnumWrappable

#### `wrap(BackedEnum|string|null $value, bool $strict = true): ?static`

Safely casts a string or an existing enum instance to the enum type. Returns `null` for empty or `null` values. Set `strict: false` to use `tryFrom()` instead of `from()`, which suppresses exceptions on invalid input.

```php
CourseStatusEnum::wrap('draft');                  // CourseStatusEnum::DRAFT
CourseStatusEnum::wrap(CourseStatusEnum::DRAFT);  // CourseStatusEnum::DRAFT
CourseStatusEnum::wrap(null);                     // null
CourseStatusEnum::wrap('invalid', strict: false); // null
```

#### `is(BackedEnum|string $value): bool` · `isNot(BackedEnum|string $value): bool`

```php
$status = CourseStatusEnum::DRAFT;

$status->is('draft');                        // true
$status->is(CourseStatusEnum::DRAFT);        // true
$status->isNot(CourseStatusEnum::PUBLISHED); // true
```

#### `isAny(array $values): bool` · `isNotAny(array $values): bool`

```php
$status->isAny(['draft', 'pending']);                                        // true
$status->isAny([CourseStatusEnum::PUBLISHED]);                               // false
$status->isNotAny([CourseStatusEnum::PENDING, CourseStatusEnum::PUBLISHED]); // true
```

---

## Real-World Examples

### Eloquent Model

Cast a database column directly to an enum using Laravel's built-in casting:

```php
protected function casts(): array
{
    return [
        'status' => CourseStatusEnum::class,
    ];
}
```

### API Resource

Use `object()` to return a structured `value` and `name` pair in API responses:

```php
public function toArray(Request $request): array
{
    return [
        'id'     => $this->id,
        'title'  => $this->title,
        'status' => $this->status->object(),
        // ['value' => 'draft', 'name' => 'Draft']
    ];
}
```

### Select Dropdown

Return all cases as translatable options for a frontend select component:

```php
public function create(): JsonResponse
{
    return response()->json([
        'statuses' => CourseStatusEnum::toArrayTrans(),
    ]);
}
```

---

## Testing

```bash
composer test
```

---

## Changelog

Please refer to [CHANGELOG.md](CHANGELOG.md) for a detailed list of changes in each release.

---

## Credits

- [Osama Sadah](https://github.com/osama-98)
- [All Contributors](../../contributors)

---

## License

This package is open-sourced software licensed under the [MIT License](LICENSE.md).
