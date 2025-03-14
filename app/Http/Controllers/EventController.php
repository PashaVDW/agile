<?php

namespace App\Http\Controllers;

use App\Enums\EventCategoryEnum;
use App\Http\Requests\EventRequest;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $events = $this->eventService->getEvents();
        if ($request->route()->named('admin.events.index')) {
            return view('admin.events.index', ['events' => $events]);
        }
        return view('user.events.index',['events' => $events]);
    }

    public function create()
    {
        $categories = EventCategoryEnum::class;
        return view('admin.events.show', ['categories' => $categories]);
    }

    public function store(EventRequest $request)
    {
        $this->eventService->storeEvent($request);
        return to_route('admin.events.index');
    }

    public function show(Request $request, $id)
    {
        $event = $this->eventService->getEvent($id);
        $categories = EventCategoryEnum::class;
        if ($request->route()->named('admin.event.show')) {
            return view('admin.events.show', ['event' => $event, 'categories' => $categories]);
        }
        return view('user.events.show', ['event' => $event]);
    }

    public function update(EventRequest $request, $id)
    {
        $this->eventService->updateEvent($request, $id);
        return to_route('admin.events.index');
    }

    public function delete($id)
    {
        $this->eventService->deleteEvent($id);
        return to_route('admin.events.index');
    }
}
