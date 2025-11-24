<?php

namespace Osama\LaravelEnums;

trait EnumTranslatable
{
    use EnumArrayable;

    /**
     * Get enum Arrayable as translation
     */
    public static function toArrayTrans(): array
    {
        $cases = [];

        foreach (self::values() as $value) {
            $cases[] = [
                'id' => $value,
                'name' => __(static::getTransKey().".$value"),
            ];
        }

        return $cases;
    }

    /**
     * Get enum trans key
     */
    public static function getTransKey(): string
    {
        return 'enums.'.str(rtrim(class_basename(static::class), 'Enum'))->snake()->plural();
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
        return __($this->transKey(), [], $locale);
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
