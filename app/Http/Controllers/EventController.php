<?php

namespace App\Http\Controllers;

use App\Enums\EventCategoryEnum;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->getEvents()->paginate(10);
        return view('admin.events.index', ['events' => $events]);
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

    public function show($id)
    {
        $event = $this->eventService->getEvent($id);
        $categories = EventCategoryEnum::class;
        return view('admin.events.show', ['event' => $event, 'categories' => $categories]);
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
