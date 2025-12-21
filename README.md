<div align="center">

![Laravel Enum Translatable](.github/logo.svg)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/osama-98/laravel-enum-translatable.svg?style=flat-square)](https://packagist.org/packages/osama-98/laravel-enum-translatable)
[![License](https://img.shields.io/packagist/l/osama-98/laravel-enum-translatable.svg?style=flat-square)](https://packagist.org/packages/osama-98/laravel-enum-translatable)

A Laravel package for translatable enums.

</div>

## Documents
[Meduim](https://masteryoflaravel.medium.com/stop-hardcoding-translations-the-revolutionary-way-to-build-multilingual-laravel-apps-with-bf303533b8b0)
[Laravel News](https://masteryoflaravel.medium.com/stop-hardcoding-translations-the-revolutionary-way-to-build-multilingual-laravel-apps-with-bf303533b8b0)

## Features

- 🌍 **Translation Support**: Automatically translate enum values using Laravel's translation system
- 📦 **Array Conversion**: Convert enums to arrays with `value` and `name` for easy API responses
- 🎯 **Object Method**: Get enum as an object with `value` and translated `name`
- 🔄 **Multiple Locales**: Support for multiple locales with `allTrans()` method
- 🎨 **Easy Integration**: Simple trait-based implementation
- 🧩 **Modular Support**: Optional support for modular Laravel applications

## Installation

You can install the package via composer:

```bash
composer require osama-98/laravel-enum-translatable
```


## Configuration

Publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-enums-config"
```

This will create a `config/laravel-enums.php` file with the following structure:

```php
return [
    'supported_locales' => [
        'en',
        // 'ar',
        // 'es',
        // ...
    ],

    /*
    | Enable modular support (e.g., nWidart/laravel-modules)
    | When enabled, translations will be loaded from module namespaces
    */
    'modular_enabled' => false,

    /*
    | Translation namespace resolver class
    | You can extend TranslationNamespaceResolver and override the
    | resolveModuleNamespace() method to customize how module namespaces are detected
    */
    'namespace_resolver' => \Osama\LaravelEnums\TranslationNamespaceResolver::class,
];
```

## Usage

### Creating a Translatable Enum

Create an enum that uses the `EnumTranslatable` trait:

```php
<?php

namespace App\Enums\Course;

use Osama\LaravelEnums\Concerns\EnumTranslatable;

enum CourseStatusEnum: string
{
    use EnumTranslatable;

    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
}
```

### Setting Up Translation Files

Create translation files in your `lang` directory. The translation key is automatically generated based on the enum class name.

For `CourseStatusEnum`, the translation key will be `enums.course_statuses` (the class name without `Enum` suffix, converted to snake_case and pluralized).

**lang/en/enums.php:**
```php
return [
    'course_statuses' => [
        'draft' => 'Draft',
        'pending' => 'Pending',
        'published' => 'Published',
    ],
];
```

**lang/ar/enums.php:**
```php
return [
    'course_statuses' => [
        'draft' => 'مسودة',
        'pending' => 'قيد المراجعة',
        'published' => 'منشور',
    ],
];
```

### Using Enums in Models

You can use translatable enums in your Eloquent models with automatic casting:

```php
<?php

namespace App\Models;

use App\Enums\Course\CourseStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'status',
        // ...
    ];

    protected function casts(): array
    {
        return [
            'status' => CourseStatusEnum::class,
        ];
    }
}
```

### Getting Enum Options as Array (with value and name)

Use the `toArrayTrans()` static method to get all enum options as an array with `value` and `name`:

```php
// Returns:
// [
//     ['value' => 'draft', 'name' => 'Draft'],
//     ['value' => 'pending', 'name' => 'Pending'],
//     ['value' => 'published', 'name' => 'Published'],
// ]
$options = CourseStatusEnum::toArrayTrans();
```


```php
// In a controller
public function getStatusOptions()
{
    return response()->json([
        'data' => CourseStatusEnum::toArrayTrans()
    ]);
}
```

### Getting Enum as Object (with value and name)

Use the `object()` method on an enum instance to get it as an object with `value` and translated `name`:

```php
$status = CourseStatusEnum::DRAFT;

// Returns: ['value' => 'draft', 'name' => 'Draft']
$statusObject = $status->object();
```

### Using in API Resources

You can use the `object()` method in your API resources to return enum values with their translations:

```php
<?php

namespace App\Http\Resources\V1\Course;

use App\Enums\Course\CourseStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->whenHas('status', fn (CourseStatusEnum $status) => $status->object()),
            // Returns: ['value' => 'draft', 'name' => 'Draft']
        ];
    }
}
```

### Getting Translated Value

Get the translated value for a specific locale:

```php
$status = CourseStatusEnum::DRAFT;

// Get translation in current locale
$translated = $status->trans(); // 'Draft' or 'مسودة' depending on locale

// Get translation in specific locale
$arabic = $status->trans('ar'); // 'مسودة'
$english = $status->trans('en'); // 'Draft'
```

### Getting All Translations

Get all translations for an enum case across all supported locales:

```php
$status = CourseStatusEnum::DRAFT;

// Returns: ['en' => 'Draft', 'ar' => 'مسودة']
$allTranslations = $status->allTrans();
```

### Additional Helper Methods

The package also provides several helper methods from the `EnumArrayable` trait:

```php
// Get all enum case names
$names = CourseStatusEnum::names(); // ['DRAFT', 'PENDING', 'PUBLISHED']

// Get all enum values
$values = CourseStatusEnum::values(); // ['draft', 'pending', 'published']

// Get enum as key-value array
$array = CourseStatusEnum::toArray(); // ['draft' => 'DRAFT', 'pending' => 'PENDING', ...]

// Get random enum case
$random = CourseStatusEnum::randomCase();

// Get random enum value
$randomValue = CourseStatusEnum::randomValue();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Osama Sadah](https://github.com/osama-98)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
