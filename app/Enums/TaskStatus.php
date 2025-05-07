<?php

namespace App\Enums;

enum TaskStatus: int
{
    case PENDING = 0;
    case IN_PROGRESS = 1;
    case COMPLETED = 2;
    case CANCELLED = 3;

    public function getLabel(): string
    {
        return match ($this) {
            TaskStatus::PENDING => 'Pending',
            TaskStatus::IN_PROGRESS => 'In Progress',
            TaskStatus::CANCELLED => 'Cancelled',
            TaskStatus::COMPLETED => 'Completed',
        };
    }
}
