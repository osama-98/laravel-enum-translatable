<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumArrayable;

enum MirrorEnum: string
{
    use EnumArrayable;

    case FIRST = 'first';
    case SECOND = 'second';
}
