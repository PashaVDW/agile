<?php

namespace App\Http\Controllers;

use App\Services\WeeztixService;
use Illuminate\Http\Request;

class OAuthController extends Controller
{
    private WeeztixService $weeztixService;
    public function __construct(WeeztixService $weeztixService)
    {
        $this->weeztixService = $weeztixService;
    }

    public function callback(Request $request)
    {
        $this->weeztixService->callback($request);
        return redirect()->route('home');
    }
    public function getOrder()
    {
        $this->weeztixService->registerUserEvent('9c666ddd-e90f-4942-8676-7d6c76afc2c8');
    }
}
