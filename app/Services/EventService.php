<?php

namespace App\Services;

use App\Enums\EventCategoryEnum;
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
        $data['image'] = ImageService::StoreImage($request, 'image') ?? ($data['image'] ?? null);
        Event::create($data);
    }

    public function updateEvent($request, $id)
    {
        $data = $request->validated();
        $data['image'] = ImageService::StoreImage($request, 'image') ?? ($data['image'] ?? null);
        Event::find($id)->update($data);
    }

    public function deleteEvent($id)
    {
        Event::destroy($id);
    }
}
