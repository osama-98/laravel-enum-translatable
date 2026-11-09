<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumTranslatable;

enum Season: string
{
    use EnumTranslatable;

    case SUMMER = 'summer';
}
