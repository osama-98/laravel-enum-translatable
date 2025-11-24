<?php

namespace Osama\LaravelEnums;

use BackedEnum;
use Illuminate\Support\Arr;

trait EnumArrayable
{
    use EnumWrappable;

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toArray(): array
    {
        return array_combine(self::values(), self::names());
    }

    /**
     * Return a random value of enum values
     */
    public static function randomValue(BackedEnum|array|string|null $except = null): string
    {
        $randomCase = self::randomCase($except);

        return $randomCase->value;
    }

    /**
     * Return a random case of enum cases
     */
    public static function randomCase(BackedEnum|array|string|null $except = null): self
    {
        $cases = self::cases();
        if (! empty($except)) {
            $except = Arr::map(Arr::wrap($except), fn ($value) => $value instanceof BackedEnum ? $value->value : $value);
            $cases = Arr::where($cases, fn ($case) => ! in_array($case->value, $except));
        }

        // This will throw an exception if the cases array is empty:
        // "You requested 1 or more items, but there are only 0 items available"
        return Arr::random($cases);
    }
}
