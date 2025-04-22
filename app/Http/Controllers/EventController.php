<?php

namespace App\Http\Controllers;

use App\Enums\EventCategoryEnum;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Services\EventService;
use App\Services\SearchService;
use Illuminate\Http\Request;
use App\Services\SponsorService;

class EventController extends Controller
{
    private EventService $eventService;
    private SponsorService $sponsorService;
    private SearchService $searchService;

    public function __construct(EventService $eventService, SponsorService $sponsorService, SearchService $searchService)
    {
        $this->eventService = $eventService;
        $this->searchService = $searchService;
        $this->sponsorService = $sponsorService;
    }

    public function index(Request $request)
    {
        $query = $this->eventService->getEvents();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has("search") && $request->search != '') {
            $this->searchService->search($query, $request->search, Event::class);
        }
        
        $bindings = array_keys(request()->query());

        if ($request->route()->named('admin.events.index')) {
            $events = $query->paginate(10)->appends(request()->query());
            $homeImages = $this->eventService->getHomeImages();
            return view('admin.events.index', ['events' => $events, 'bindings' => $bindings, 'homeImages' => $homeImages]);
        }
        $events = $query->whereNot('category', EventCategoryEnum::COMMUNITY->value)->paginate(10)->appends(request()->query());
        return view('user.events.index',['events' => $events, $bindings]);
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

    public function community(Request $request)
    {
        $query = $this->eventService->getEvents()->where('category', EventCategoryEnum::COMMUNITY->value);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(10)->appends(request()->query());
        $bindings = array_keys(request()->query());

        return view('user.events.index',['events' => $events, $bindings]);
    }
}
