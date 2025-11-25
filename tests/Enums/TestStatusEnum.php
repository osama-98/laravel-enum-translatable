<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumTranslatable;

enum TestStatusEnum: string
{
    use EnumTranslatable;

    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
}

