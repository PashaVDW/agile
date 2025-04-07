<?php

namespace App\Http\Controllers;

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

    public function announcements()
    {
        $announcements = $this->announcementService->getAnnouncements()->paginate(10);
        return view('user.announcements.index', ['announcements' => $announcements]);
    }
}
