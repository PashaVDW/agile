<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;

class GoogleCalendarService
{
    public function createEvent(string $startDate, string $endDate, string $title, string $category, int $eventId)
    {
        $event = new \Spatie\GoogleCalendar\Event();
        $event->name = $title;
        $event->description = $category;
        $event->startDateTime = Carbon::parse($startDate);
        $event->endDateTime = Carbon::parse($endDate);
        $savedEvent = $event->save();

        Event::where('id', $eventId)->update([
            'google_calendar_event_id' => $savedEvent->id,
        ]);
    }
}
