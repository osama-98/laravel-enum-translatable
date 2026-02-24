# Changelog

## 1.5.0 - 2026-02-24

### Added

- Added `make:enum` artisan command to scaffold enum classes with `EnumTranslatable` by default
  - `--int` flag to generate an integer backed enum
  - `--arrayable` flag to use `EnumArrayable` instead of `EnumTranslatable`
  - `--wrappable` flag to use `EnumWrappable` instead of `EnumTranslatable`
  - Supports nested namespaces via `/` separator (e.g. `Admin/UserStatus`)
  - Auto-appends the `Enum` suffix if omitted
  - Prompts interactively for the name if not provided
- Added `toCollection()` static method to `EnumArrayable` — Collection equivalent of `toArray()`
- Added `toTransCollection(?string $locale = null)` static method to `EnumTranslatable` — Collection equivalent of `toArrayTrans()`

### Updated

- `toArrayTrans()` now accepts an optional `?string $locale = null` parameter to translate into a specific locale without changing the app locale

**Full Changelog**: https://github.com/osama-98/laravel-enum-translatable/compare/1.4.0...1.5.0

## 1.4.0 - 2026-02-09

### Added

- Added `matching()` static method for wildcard pattern matching on enum values
- Added `notMatching()` static method for inverse wildcard pattern matching
- Added `startsWith()` static method to filter enum cases by prefix
- Added `endsWith()` static method to filter enum cases by suffix
- Added `contains()` static method to filter enum cases by substring

**Full Changelog**: https://github.com/osama-98/laravel-enum-translatable/compare/1.3.0...1.4.0

## 1.3.0 - 2026-01-17

Return the enum name as a fallback instead of dotted notation translation path

## 1.2.0 - 2025-12-29

### Added

- Added `isNot()` method to check if enum does NOT match a value
- Added `isAny()` method to check if enum matches any of the given values
- Added `isNotAny()` method to check if enum does NOT match any of the given values
- Added `only()` static method to filter enum cases to only include specified values
- Added `except()` static method to filter enum cases excluding specified values

**Full Changelog**: https://github.com/osama-98/laravel-enum-translatable/compare/1.1.0...1.2.0

## 1.1.0 - 2025-11-26

**Full Changelog**: https://github.com/osama-98/laravel-enum-translatable/compare/1.0.0...1.1.0

## 1.0.0 - 2025-11-25

### What's Changed

* Bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/osama-98/laravel-enum-translatable/pull/2
* Bump actions/checkout from 4 to 6 by @dependabot[bot] in https://github.com/osama-98/laravel-enum-translatable/pull/5
* Bump stefanzweifel/git-auto-commit-action from 5 to 7 by @dependabot[bot] in https://github.com/osama-98/laravel-enum-translatable/pull/4

### New Contributors

* @dependabot[bot] made their first contribution in https://github.com/osama-98/laravel-enum-translatable/pull/2

**Full Changelog**: https://github.com/osama-98/laravel-enum-translatable/commits/1.0.0
