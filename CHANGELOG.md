# Changelog

## Unreleased

### Breaking Changes

- `EnumWrappable::wrap()` no longer passes foreign enum instances through unchanged. Previously `Status::wrap(Role::ADMIN)` returned the `Role` case as-is; it now unwraps to `->value` and re-resolves against the calling enum, so it returns the matching `Status` case, throws `ValueError` when there is no match in strict mode, or returns `null` in non-strict mode.

### Fixed

- `wrap()` returned `null` for a case backed by the string `'0'` because the emptiness check used `empty()`. It now only short-circuits on `null` and `''`.

### Changed

- `wrap()` return type narrowed from `?BackedEnum` to `?static`, so `Status::wrap($value)` is typed as `?Status` for static analysis and IDE completion. Callers typed against `BackedEnum` are unaffected; any subclass overriding `wrap()` with a wider return type must be updated.

## 2.3 - 2026-07-07

### What's Changed

* chore(deps): bump actions/checkout from 6 to 7 by @dependabot[bot] in https://github.com/osama-98/laravel-enum-translatable/pull/13
* [FIX] Issues with using rtrim function by @devhammed in https://github.com/osama-98/laravel-enum-translatable/pull/14

**Full Changelog**: https://github.com/osama-98/laravel-enum-translatable/compare/2.2.1...2.3

## 2.2.1 - 2026-05-31

**Full Changelog**: https://github.com/osama-98/laravel-enum-translatable/compare/2.2.0...2.2.1

## 2.1.0 - 2026-03-23

- Add Laravel13 support

## 2.0.0 - 2026-03-16

### Breaking Changes

- Dropped Laravel 10 support. Minimum required version is now Laravel 11.

## 1.5.2 - 2026-03-14

- enhance composer.json keywords

## 1.5.1 - 2026-03-14

- enhance composer keywords

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
