<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Services\EventService;

class EventController extends Controller
{
    private EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->getEvents();
        return view('events.index', ['events' => $events]);
    }

    public function create()
    {
        return view('events.show');
    }

    public function store(EventRequest $request)
    {
        $this->eventService->storeEvent($request);
        return redirect()->route('events.index');
    }

    public function event($id)
    {
        $event = $this->eventService->getEvent($id);
        return view('events.show', ['event' => $event]);
    }

    public function update(EventRequest $request, $id)
    {
        $this->eventService->updateEvent($request, $id);
        return redirect()->route('events.index');
    }

    public function delete($id)
    {
        $this->eventService->deleteEvent($id);
        return redirect()->route('events.index');
    }
}
