<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\AnnouncementService;

class HomeController extends Controller
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->getEvents()->limit(4)->get();
        $randomEvent = $this->eventService->getRandomEvent();

        return view('home', ['events' => $events, 'randomEvent' => $randomEvent]);
    }

}
