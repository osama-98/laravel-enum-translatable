<?php

namespace Osama\LaravelEnums\Tests\Enums;

use Osama\LaravelEnums\Concerns\EnumArrayable;

enum PatternEnum: string
{
    use EnumArrayable;

    case ACTIVE_USER = 'active_user';
    case ACTIVE_ADMIN = 'active_admin';
    case INACTIVE_USER = 'inactive_user';
    case INACTIVE_ADMIN = 'inactive_admin';
    case PENDING_USER = 'pending_user';
}
