<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumTranslatable;

enum GlossaryRuleAction: string
{
    use EnumTranslatable;

    case ALWAYS_TRANSLATE = 'always_translate';
    case DO_NOT_TRANSLATE = 'do_not_translate';
}
