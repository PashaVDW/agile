<?php

namespace App\Http\Controllers;

use App\Models\Event;

class CalenderController extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->where('status', 'active')
            ->orderBy('start_date', 'ASC') // Zorg ervoor dat dit 'ASC' is om de evenementen chronologisch te sorteren
            ->get();

        return view('user.calender.index', ['events' => $events]);
    }
}
