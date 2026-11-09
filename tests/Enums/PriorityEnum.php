<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumArrayable;

enum PriorityEnum: int
{
    use EnumArrayable;

    case NONE = 0;
    case LOW = 1;
    case HIGH = 2;
}
