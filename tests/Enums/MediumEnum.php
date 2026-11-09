<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumTranslatable;

enum MediumEnum: string
{
    use EnumTranslatable;

    case PRINT = 'print';
}
