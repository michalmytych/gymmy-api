<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RealizationStatusType extends Enum
{
    public const CREATED = 0;

    public const RUNNING = 1;

    public const COMPLETED = 2;
}
