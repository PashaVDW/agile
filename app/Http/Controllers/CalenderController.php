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
}
