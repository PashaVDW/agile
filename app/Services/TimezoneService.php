<?php

namespace App\Services;


class TimezoneService
{
    public static function getTimezone($time)
    {
        return $time->timezone('CET')->format('Y-m-d H:i:s');
    }
}
