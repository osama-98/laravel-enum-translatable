<?php

namespace Osama\LaravelEnums\Concerns;

use BackedEnum;

trait EnumWrappable
{
    public static function wrap(BackedEnum|string|null $enum, bool $strict = true): ?BackedEnum
    {
        if (empty($enum)) {
            return null;
        }

        if ($enum instanceof BackedEnum) {
            return $enum;
        }

        return $strict ? static::from($enum) : static::tryFrom($enum);
    }

    /**
     * Check if the current enum instance matches the given enum or string value.
     */
    public function is(BackedEnum|string $value): bool
    {
        if ($value instanceof BackedEnum) {
            return $this === $value;
        }

        return $this->value === $value;
    }

    /**
     * Check if the current enum instance does NOT match the given enum or string value.
     */
    public function isNot(BackedEnum|string $value): bool
    {
        return ! $this->is($value);
    }

    /**
     * Check if the current enum instance matches any of the given values.
     */
    public function isAny(array $values): bool
    {
        foreach ($values as $value) {
            if ($this->is($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the current enum instance does NOT match any of the given values.
     */
    public function isNotAny(array $values): bool
    {
        return ! $this->isAny($values);
    }
}
