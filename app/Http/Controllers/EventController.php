<?php

namespace App\Http\Controllers;

use App\Enums\EventCategoryEnum;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use App\Services\SponsorService;

class EventController extends Controller
{
    private EventService $eventService;
    private SponsorService $sponsorService;
    public function __construct(EventService $eventService, SponsorService $sponsorService)
    {
        $this->eventService = $eventService;
        $this->sponsorService = $sponsorService;
    }

    public function index(Request $request)
    {
        $events = $this->eventService->getEvents()->paginate(10);
        if ($request->route()->named('admin.events.index')) {
            return view('admin.events.index', ['events' => $events]);
        }
        return view('user.events.index',['events' => $events]);
    }

    public function create()
    {
        $categories = EventCategoryEnum::class;
        $sponsors = $this->sponsorService->getSponsors()->get();
        return view('admin.events.show', ['categories' => $categories, 'sponsors' => $sponsors]);
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
        $sponsors = $this->sponsorService->getSponsors()->get();
        if ($request->route()->named('admin.event.show')) {
            return view('admin.events.show', ['event' => $event, 'categories' => $categories, 'sponsors' => $sponsors]);
        }
        return view('user.events.show', ['event' => $event, 'sponsors' => $sponsors]);
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
