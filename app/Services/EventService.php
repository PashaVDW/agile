<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Sponsor;

class EventService
{
    public function getEvents()
    {
        return Event::query()->with('sponsors');
    }

    public function getEvent($id)
    {
        return Event::find($id);
    }

    public function storeEvent($request)
    {
        $data = $request->validated();
        $data['image'] = ImageService::StoreImage($request, 'image', 'Events') ?? ($data['image'] ?? null);
        $event = Event::create($data);
        $event->sponsors()->sync($request->input('sponsors', []));
    }

    public function updateEvent($request, $id)
    {
        $data = $request->validated();
        $data['image'] = ImageService::StoreImage($request, 'image', 'Events') ?? ($data['image'] ?? null);
        $event = Event::find($id);
        $event->update($data);
        $event->sponsors()->sync($request->input('sponsors', []));
    }

    public function deleteEvent($id)
    {
        Event::destroy($id);
    }
}
