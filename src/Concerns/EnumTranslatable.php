<?php

namespace Osama\LaravelEnums\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

trait EnumTranslatable
{
    use EnumArrayable;

    public static function toArrayTrans(?string $locale = null): array
    {
        return array_map(fn (self $case) => [
            'value' => $case->value,
            'name' => $case->trans($locale),
        ], self::cases());
    }

    public static function toTransCollection(?string $locale = null): Collection
    {
        return collect(self::toArrayTrans($locale));
    }

    /**
     * Get enum trans key with namespace
     */
    public static function getTransKey(): string
    {
        $namespace = static::getTranslationNamespace();
        $key = str(rtrim(class_basename(static::class), 'Enum'))->snake()->plural();

        return $namespace ? "$namespace::enums.$key" : "enums.$key";
    }

    /**
     * Get the translation namespace (module or default)
     */
    protected static function getTranslationNamespace(): ?string
    {
        $resolver = resolve(config('laravel-enums.namespace_resolver'));

        return $resolver->resolve(static::class);
    }

    /**
     * Get enum as an array value with trans
     */
    public function object(): array
    {
        return [
            'value' => $this->value,
            'name' => $this->trans(),
        ];
    }

    /**
     * Trans enum value
     */
    public function trans(?string $locale = null): string
    {
        $key = $this->transKey();

        if (Lang::has($key, $locale)) {
            return Lang::get($key, [], $locale);
        }

        return $this->value;
    }

    /**
     * Trans key for enum value
     */
    public function transKey(): string
    {
        return static::getTransKey().".$this->value";
    }

    /**
     * Return all translations for the enum case
     */
    public function allTrans(): array
    {
        return array_reduce(config('laravel-enums.supported_locales'), function ($result, $locale) {
            $result[$locale] = $this->trans($locale);

            return $result;
        });
    }
}
