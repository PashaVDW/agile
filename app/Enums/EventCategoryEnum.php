<?php

namespace App\Enums;

enum EventCategoryEnum: string
{
    case EVENT = 'event';
    case DRINKS = 'drinks';

    public static function toArray(): array
    {
        return [
            self::EVENT->value,
            self::DRINKS->value,
        ];
    }
}
