<?php

namespace Osama\LaravelEnums;

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
}
