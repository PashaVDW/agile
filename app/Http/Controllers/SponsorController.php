<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::with('events')->get();

        return view('sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        $events = Event::all();

        return view('sponsors.create', compact('events'));
    }

    public function store(Request $request)
    {
        $sponsor = Sponsor::create($request->except('events'));
        $sponsor->events()->sync($request->input('events', []));

        return redirect()->route('sponsors.index');
    }

    public function show(Sponsor $sponsor)
    {
        return view('sponsors.show', compact('sponsor'));
    }

    public function edit(Sponsor $sponsor)
    {
        $events = Event::all();

        return view('sponsors.edit', compact('sponsor', 'events'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $sponsor->update($request->except('events'));
        $sponsor->events()->sync($request->input('events', []));

        return redirect()->route('sponsors.index');
    }

    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();

        return redirect()->route('sponsors.index');
    }
}
