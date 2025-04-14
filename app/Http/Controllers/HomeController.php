<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\AnnouncementService;

class HomeController extends Controller
{
    private EventService $eventService;
    private AnnouncementService $announcementService;

    public function __construct(EventService $eventService, AnnouncementService $announcementService)
    {
        $this->eventService = $eventService;
        $this->announcementService = $announcementService;
    }

    public function index()
    {
        $events = $this->eventService->getEvents()->limit(4)->get();
        $randomEvent = $this->eventService->getRandomEvent();

        return view('home', ['events' => $events, 'randomEvent' => $randomEvent]);
    }

}
