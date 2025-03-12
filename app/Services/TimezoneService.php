<?php

namespace App\Services;

class TimezoneService
{
    public static function getTimezone($time)
    {
        return $time->setTimezone('CET')->format('H:i:s d-m-Y');
    }
}
