<?php

namespace App\Http\Controllers;

use App\Enums\EventCategoryEnum;
use App\Services\EventService;

use App\Models\Token;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $token = Token::first();

        $events = $this->eventService->getEvents()->whereNot('category', EventCategoryEnum::COMMUNITY->value)->limit(4)->get();
        $homeImages = $this->eventService->getHomeImages();

        return view('home', ['events' => $events, 'homeImages' => $homeImages, 'refresh_token' => $token ? $token->refresh_token : null]);
    }
}
