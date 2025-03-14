<?php

namespace App\Enums;

enum EventCategoryEnum: string
{
    case EVENT = 'EVENT';
    case DRINKS = 'DRINKS';

    public static function toArray(): array
    {
        return [
            self::EVENT->value,
            self::DRINKS->value,
        ];
    }
}
