<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumArrayable;

enum SimpleEnum: string
{
    use EnumArrayable;

    case FIRST = 'first';
    case SECOND = 'second';
    case THIRD = 'third';
}

