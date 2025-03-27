<?php

namespace App\Http\Controllers;

use App\Models\OAuthToken;
use Illuminate\Http\Request;

use App\Services\EventService;

class HomeController extends Controller
{
    private EventService $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $token = OAuthToken::where('user_id', auth()->id())->first();
        $events = $this->eventService->getEvents()->limit(4)->get();
        $randomEvent = $this->eventService->getRandomEvent();

        return view('home', ['events' => $events, 'randomEvent' => $randomEvent, 'refresh_token' => $token ? $token->refresh_token : null]);
    }
}
