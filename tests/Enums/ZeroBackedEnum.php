<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumArrayable;

enum ZeroBackedEnum: string
{
    use EnumArrayable;

    case ZERO = '0';
    case ONE = '1';
}
