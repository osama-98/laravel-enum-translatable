<?php

namespace Osama\LaravelEnums\Concerns;

use BackedEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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

    public static function toCollection(): Collection
    {
        return collect(self::toArray());
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

    /**
     * Get enum cases filtered to only include the specified values.
     *
     * @return array<self>
     */
    public static function only(array $values): array
    {
        $normalized = Arr::map($values, fn ($value) => $value instanceof BackedEnum ? $value->value : $value);

        return Arr::where(self::cases(), fn ($case) => in_array($case->value, $normalized));
    }

    /**
     * Get enum cases excluding the specified values.
     *
     * @return array<self>
     */
    public static function except(array $values): array
    {
        $normalized = Arr::map($values, fn ($value) => $value instanceof BackedEnum ? $value->value : $value);

        return Arr::where(self::cases(), fn ($case) => ! in_array($case->value, $normalized));
    }

    /**
     * Get enum cases whose values match the given wildcard pattern.
     *
     * @return array<self>
     */
    public static function matching(string $pattern): array
    {
        $regex = '/^'.str_replace('\*', '.*', preg_quote($pattern, '/')).'$/i';

        return Arr::where(self::cases(), fn ($case) => preg_match($regex, $case->value));
    }

    /**
     * Get enum cases whose values do not match the given wildcard pattern.
     *
     * @return array<self>
     */
    public static function notMatching(string $pattern): array
    {
        $regex = '/^'.str_replace('\*', '.*', preg_quote($pattern, '/')).'$/i';

        return Arr::where(self::cases(), fn ($case) => ! preg_match($regex, $case->value));
    }

    /**
     * Get enum cases whose values start with the given prefix.
     *
     * @return array<self>
     */
    public static function startsWith(string $prefix): array
    {
        return self::matching($prefix.'*');
    }

    /**
     * Get enum cases whose values end with the given suffix.
     *
     * @return array<self>
     */
    public static function endsWith(string $suffix): array
    {
        return self::matching('*'.$suffix);
    }

    /**
     * Get enum cases whose values contain the given substring.
     *
     * @return array<self>
     */
    public static function contains(string $substring): array
    {
        return self::matching('*'.$substring.'*');
    }
}
