<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use JetBrains\PhpStorm\Pure;

final class RealizationStatusType extends Enum
{
    public const CREATED = 0;

    public const RUNNING = 1;

    public const COMPLETED = 2;

    #[Pure] public function isNotCompleted(): bool
    {
        return !$this->is(RealizationStatusType::COMPLETED);
    }

    #[Pure] public function isRunning(): bool
    {
        return $this->is(RealizationStatusType::RUNNING);
    }
}
