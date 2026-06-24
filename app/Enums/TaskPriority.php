<?php

namespace App\Enums;

enum TaskPriority: int
{
    case LOW = 0;
    case MEDIUM = 1;
    case HIGH = 2;

    public function getLabel(): string
    {
        return match ($this) {
            TaskPriority::LOW => 'Low',
            TaskPriority::MEDIUM => 'Medium',
            TaskPriority::HIGH => 'High',
        };
    }
}
