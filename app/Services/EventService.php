<?php

namespace App\Services;

use App\Models\Event;

class EventService
{
    public function getEvents()
    {
        return Event::all();
    }

    public function getEvent($id)
    {
        return Event::find($id);
    }

    public function storeEvent($request)
    {
        $data = $request->validated();
        $data = ImageService::StoreImage($request, 'image') ?? $data;
        Event::create($data);
    }

    public function updateEvent($request, $id)
    {
        $data = $request->validated();
        $data = ImageService::StoreImage($request, 'image') ?? $data;
        Event::find($id)->update($data);
    }

    public function deleteEvent($id)
    {
        Event::destroy($id);
    }
}
