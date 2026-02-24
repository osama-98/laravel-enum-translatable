<div align="center">

![Laravel Enum Translatable](.github/logo.svg)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/osama-98/laravel-enum-translatable.svg?style=flat-square)](https://packagist.org/packages/osama-98/laravel-enum-translatable)
[![Total Downloads](https://img.shields.io/packagist/dt/osama-98/laravel-enum-translatable.svg)](https://packagist.org/packages/osama-98/laravel-enum-translatable)
[![License](https://img.shields.io/packagist/l/osama-98/laravel-enum-translatable.svg?style=flat-square)](https://packagist.org/packages/osama-98/laravel-enum-translatable)

**Supercharge your Laravel enums with translations, array helpers, and comparison methods — all via simple traits.**

[Medium Article](https://masteryoflaravel.medium.com/stop-hardcoding-translations-the-revolutionary-way-to-build-multilingual-laravel-apps-with-bf303533b8b0) · [Laravel News](https://laravel-news.com/translatable-enums)

</div>

---

## Requirements

- PHP 8.2+
- Laravel 10, 11, or 12

---

## Installation

```bash
composer require osama-98/laravel-enum-translatable
```

---

## Quick Start

**1. Generate an enum:**

```bash
php artisan make:enum OrderStatus
```

**2. Add your cases:**

```php
enum OrderStatusEnum: string
{
    use EnumTranslatable;

    case PENDING   = 'pending';
    case SHIPPED   = 'shipped';
    case DELIVERED = 'delivered';
}
```

**3. Add translations in `lang/en/enums.php`:**

```php
return [
    'order_statuses' => [
        'pending'   => 'Pending',
        'shipped'   => 'Shipped',
        'delivered' => 'Delivered',
    ],
];
```

**4. Use it:**

```php
OrderStatusEnum::PENDING->trans();       // 'Pending'
OrderStatusEnum::PENDING->trans('ar');   // 'قيد الانتظار'
OrderStatusEnum::toArrayTrans();         // [['value' => 'pending', 'name' => 'Pending'], ...]
```

---

## Configuration

Publish the config file to customize supported locales and modular support:

```bash
php artisan vendor:publish --tag="laravel-enums-config"
```

`config/laravel-enums.php`:

```php
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
    | Extend TranslationNamespaceResolver to customize the resolution logic.
    */
    'namespace_resolver' => \Osama\LaravelEnums\TranslationNamespaceResolver::class,

];
```

---

## Available Traits

The package ships three traits that build on each other:

```
EnumTranslatable
 └── EnumArrayable
      └── EnumWrappable
```

| Trait | Best for |
|---|---|
| `EnumTranslatable` | Enums that need translated labels (includes everything below) |
| `EnumArrayable` | Enums used for filtering/listing without translation |
| `EnumWrappable` | Enums that only need comparison and safe-casting helpers |

---

## Generating Enums

Use the `make:enum` artisan command to scaffold a new enum class:

```bash
# String backed with EnumTranslatable (default)
php artisan make:enum OrderStatus

# Integer backed
php artisan make:enum OrderStatus --int

# With EnumArrayable instead
php artisan make:enum OrderStatus --arrayable

# With EnumWrappable instead
php artisan make:enum OrderStatus --wrappable
```

> **Note:** `--arrayable` already includes `EnumWrappable` internally, so there is no need to pass both.

Generated files are placed in `app/Enums/`. Nested namespaces are supported using `/`:

```bash
php artisan make:enum Admin/UserStatus
# → app/Enums/Admin/UserStatusEnum.php
# → namespace App\Enums\Admin
```

> The `Enum` suffix is appended automatically if not included in the name.

---

## Usage

All examples use the following enum:

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

The translation key is derived automatically from the class name:

- Strip the `Enum` suffix
- Convert to `snake_case`
- Pluralize
- Nest under the `enums` key

`CourseStatusEnum` → `enums.course_statuses`

Create one `enums.php` file per locale inside your `lang/` directory:

```
lang/
├── en/
│   └── enums.php
├── ar/
│   └── enums.php
```

```php
// lang/en/enums.php
return [
    'course_statuses' => [
        'draft'     => 'Draft',
        'pending'   => 'Pending',
        'published' => 'Published',
    ],
];
```

```php
// lang/ar/enums.php
return [
    'course_statuses' => [
        'draft'     => 'مسودة',
        'pending'   => 'قيد المراجعة',
        'published' => 'منشور',
    ],
];
```

---

### `EnumTranslatable`

#### `trans(?string $locale = null): string`

Returns the translated label for the current case in the given locale (defaults to the app locale). Falls back to the raw value if no translation is found.

```php
$status = CourseStatusEnum::DRAFT;

$status->trans();      // 'Draft'   (current locale)
$status->trans('ar');  // 'مسودة'
$status->trans('en');  // 'Draft'
```

#### `allTrans(): array`

Returns translations for all locales defined in `supported_locales`.

```php
CourseStatusEnum::DRAFT->allTrans();
// ['en' => 'Draft', 'ar' => 'مسودة']
```

#### `toArrayTrans(?string $locale = null): array`

Returns all cases as an array of `['value', 'name']` pairs. Uses the current app locale when `$locale` is `null`.

```php
CourseStatusEnum::toArrayTrans();      // current locale
CourseStatusEnum::toArrayTrans('ar');  // Arabic
CourseStatusEnum::toArrayTrans('en');  // English
// [
//     ['value' => 'draft',     'name' => 'Draft'],
//     ['value' => 'pending',   'name' => 'Pending'],
//     ['value' => 'published', 'name' => 'Published'],
// ]
```

#### `toTransCollection(?string $locale = null): Collection`

Same as `toArrayTrans()` but returns a Laravel `Collection`.

```php
CourseStatusEnum::toTransCollection();      // current locale
CourseStatusEnum::toTransCollection('ar');  // Arabic
// Collection([
//     ['value' => 'draft',     'name' => 'مسودة'],
//     ['value' => 'pending',   'name' => 'قيد المراجعة'],
//     ['value' => 'published', 'name' => 'منشور'],
// ])
```

#### `object(): array`

Returns the current case as a `['value', 'name']` pair using the current locale. Ideal for API responses.

```php
CourseStatusEnum::DRAFT->object();
// ['value' => 'draft', 'name' => 'Draft']
```

#### `transKey(): string`

Returns the full translation key for the current case.

```php
CourseStatusEnum::DRAFT->transKey(); // 'enums.course_statuses.draft'
```

#### `getTransKey(): string`

Returns the translation key for the enum class (without a specific case).

```php
CourseStatusEnum::getTransKey(); // 'enums.course_statuses'
```

---

### `EnumArrayable`

#### `names(): array` · `values(): array` · `toArray(): array`

```php
CourseStatusEnum::names();   // ['DRAFT', 'PENDING', 'PUBLISHED']
CourseStatusEnum::values();  // ['draft', 'pending', 'published']
CourseStatusEnum::toArray(); // ['draft' => 'DRAFT', 'pending' => 'PENDING', 'published' => 'PUBLISHED']
```

#### `toCollection(): Collection`

Same as `toArray()` but returns a Laravel `Collection`, giving you access to all collection methods.

```php
CourseStatusEnum::toCollection();
// Collection(['draft' => 'DRAFT', 'pending' => 'PENDING', 'published' => 'PUBLISHED'])

CourseStatusEnum::toCollection()->keys();   // ['draft', 'pending', 'published']
CourseStatusEnum::toCollection()->values(); // ['DRAFT', 'PENDING', 'PUBLISHED']
```

#### `only(array $values): array` · `except(array $values): array`

Filter cases by value. Accepts raw values or enum instances.

```php
CourseStatusEnum::only(['draft', 'pending']);
// [CourseStatusEnum::DRAFT, CourseStatusEnum::PENDING]

CourseStatusEnum::except([CourseStatusEnum::PUBLISHED]);
// [CourseStatusEnum::DRAFT, CourseStatusEnum::PENDING]
```

#### `randomCase(): self` · `randomValue(): string`

Pick a random case or value, with an optional exclusion list.

```php
CourseStatusEnum::randomCase();                        // e.g. CourseStatusEnum::PENDING
CourseStatusEnum::randomValue();                       // e.g. 'pending'
CourseStatusEnum::randomCase(except: CourseStatusEnum::DRAFT); // never returns DRAFT
CourseStatusEnum::randomValue(except: ['draft', 'pending']);   // always returns 'published'
```

#### `matching(string $pattern): array` · `notMatching(string $pattern): array`

Filter cases using a wildcard pattern. Case-insensitive. `*` matches any characters.

```php
CourseStatusEnum::matching('*ed');    // [PENDING, PUBLISHED]
CourseStatusEnum::notMatching('*ed'); // [DRAFT]
```

Convenience shortcuts:

```php
CourseStatusEnum::startsWith('p'); // [PENDING, PUBLISHED]
CourseStatusEnum::endsWith('ed');  // [PENDING, PUBLISHED]
CourseStatusEnum::contains('ish'); // [PUBLISHED]
```

---

### `EnumWrappable`

#### `wrap(BackedEnum|string|null $value, bool $strict = true): ?static`

Safely casts a string or an existing enum instance to the enum. Returns `null` for empty values. Use `strict: false` to use `tryFrom` instead of `from` (no exception on invalid values).

```php
CourseStatusEnum::wrap('draft');                   // CourseStatusEnum::DRAFT
CourseStatusEnum::wrap(CourseStatusEnum::DRAFT);   // CourseStatusEnum::DRAFT
CourseStatusEnum::wrap(null);                      // null
CourseStatusEnum::wrap('invalid', strict: false);  // null
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
$status->isAny(['draft', 'pending']);                                       // true
$status->isAny([CourseStatusEnum::PUBLISHED]);                              // false
$status->isNotAny([CourseStatusEnum::PENDING, CourseStatusEnum::PUBLISHED]); // true
```

---

## Real-World Examples

### Eloquent Model

Cast a column to an enum automatically:

```php
protected function casts(): array
{
    return [
        'status' => CourseStatusEnum::class,
    ];
}
```

### API Resource

Use `object()` to return a structured value + label pair:

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

### Select Dropdown (Controller)

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

Please see [CHANGELOG](CHANGELOG.md) for recent changes.

## Credits

- [Osama Sadah](https://github.com/osama-98)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
