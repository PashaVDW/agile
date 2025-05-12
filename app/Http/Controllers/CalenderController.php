<?php

namespace App\Http\Controllers;

use App\Models\Event;

class CalenderController extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->where('status', 'active')
            ->orderBy('start_date', 'ASC')
            ->get()
            ->groupBy(function ($event) {
                return $event->start_date->format('F');
            });

        return view('user.calender.index', ['events' => $events]);
    }

    public function generateICS()
    {
        $events = Event::all();
        $icsContent = $this->generateICSContent($events);

        return response($icsContent, 200)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="calendar.ics"');
    }

    private function generateICSContent($events)
    {
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//127.0.0.1:8000//NONSGML v1.0//EN\r\n";

        foreach ($events as $event) {
            if ($event->start_date) {
                $ics .= "BEGIN:VEVENT\r\n";
                $ics .= "UID:" . uniqid() . "@yourwebsite.com\r\n";
                $ics .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
                $ics .= "DTSTART:" . $event->start_date->format('Ymd\THis\Z') . "\r\n";
                $ics .= "DTEND:" . ($event->end_date ? $event->end_date->format('Ymd\THis\Z') : $event->start_date->addHour()->format('Ymd\THis\Z')) . "\r\n";
                $ics .= "SUMMARY:" . addslashes($event->title) . "\r\n";
                $ics .= "DESCRIPTION:" . addslashes($event->description) . "\r\n";
                $ics .= "END:VEVENT\r\n";
            }
        }

        $ics .= "END:VCALENDAR\r\n";

        return $ics;
    }
}
