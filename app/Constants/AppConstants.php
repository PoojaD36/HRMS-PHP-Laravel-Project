<?php

namespace App\Constants;

use App\Enums\StatusEnum;

class AppConstants
{
    public const DEFAULT_PER_PAGE = 10;

    public const MAX_PER_PAGE = 100;

    public const DEFAULT_STATUS = StatusEnum::ACTIVE->value;

    public const EMPLOYEE_CODE_PREFIX = 'EMP';
}