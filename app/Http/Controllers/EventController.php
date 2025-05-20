<?php

namespace App\Http\Controllers;

use App\Enums\EventCategoryEnum;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Services\EventService;
use App\Services\SearchService;
use App\Services\WeeztixService;
use Illuminate\Http\Request;
use App\Services\SponsorService;

class EventController extends Controller
{
    private EventService $eventService;
    private SponsorService $sponsorService;
    private SearchService $searchService;
    private WeeztixService $weeztixService;

    public function __construct(EventService $eventService, SponsorService $sponsorService, SearchService $searchService, WeeztixService $weeztixService)
    {
        $this->eventService = $eventService;
        $this->searchService = $searchService;
        $this->sponsorService = $sponsorService;
        $this->weeztixService = $weeztixService;
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
            $gallery = $this->eventService->getHomeImages();
            return view('admin.events.index', ['events' => $events, 'bindings' => $bindings, 'gallery' => $gallery]);
        }
        $events = $query->whereNot('category', EventCategoryEnum::COMMUNITY->value)->paginate(10)->appends(request()->query());
        return view('user.events.index',['events' => $events, $bindings]);
    }

    public function create()
    {
        $weeztixEvents = $this->weeztixService->getEvents();
        $categories = EventCategoryEnum::class;
        $sponsors = $this->sponsorService->getSponsors()->get();
        return view('admin.events.show', ['categories' => $categories, 'sponsors' => $sponsors, 'weeztixEvents' => $weeztixEvents]);
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
            $weeztixEvents = $this->weeztixService->getEvents();
            return view('admin.events.show', ['event' => $event, 'categories' => $categories, 'sponsors' => $sponsors, 'weeztixEvents' => $weeztixEvents]);
        }
        $availability = $this->weeztixService->getEventCapacity($event->weeztix_event_id);
        return view('user.events.show', ['event' => $event, 'sponsors' => $sponsors, 'availability' => $availability]);
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

    public function register(Request $request, $id)
    {
        $this->eventService->registerUser($request, $id);
        return to_route('user.event.show', ['id' => $id]);
    }

    public function unregister(Request $request, $id)
    {
        $this->eventService->unregisterUser($request, $id);
        return to_route('user.event.show', ['id' => $id]);
    }
}
