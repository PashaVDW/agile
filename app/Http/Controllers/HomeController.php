<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeImagesRequest;
use App\Services\EventService;

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
        $homeImages = $this->eventService->getHomeImages();

        return view('home', ['events' => $events, 'homeImages' => $homeImages]);
    }

    public function store(HomeImagesRequest $request)
    {
        $this->eventService->storeHomeImages($request);
        return to_route('admin.events.index');
    }

    public function update(HomeImagesRequest $request)
    {
        $this->eventService->updateHomeImages($request);
        return to_route('admin.events.index');
    }
}
