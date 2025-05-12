<?php

namespace App\Services;

use Carbon\Carbon;

class GoogleCalendarService
{
    public function createEvent(string $startDate, string $endDate, string $title, string $category)
    {
        $cl = new \Spatie\GoogleCalendar\Event();
        $cl->name = $title;
        $cl->description = $category;
        $cl->startDateTime = Carbon::parse($startDate);
        $cl->endDateTime = Carbon::parse($endDate);
        $cl->save();
    }
}
