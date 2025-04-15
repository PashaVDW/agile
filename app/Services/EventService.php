<?php

namespace App\Services;

use App\Models\Event;
use App\Models\HomeImages;

class EventService
{
    public function getEvents()
    {
        return Event::query()->orderBy('status', 'ASC')->orderBy('start_date', 'DESC')->with('sponsors');
    }

    public function getEvent($id)
    {
        return Event::find($id)->load('sponsors');
    }

    public function storeEvent($request)
    {
        $data = $request->validated();
        $data['banner'] = ImageService::StoreImage($request, 'banner', '/Events') ?? ($data['banner'] ?? null);
        $data['status'] = $this->setStatus($data['start_date'], $data['end_date']);
        $event = Event::create($data);
        $event->sponsors()->sync($request->input('sponsors', []));
    }

    public function updateEvent($request, $id)
    {
        $data = $request->validated();
        $data['status'] = $this->setStatus($data['start_date'], $data['end_date']);
        $event = Event::find($id);

        if ($request->hasFile('banner')) {
            ImageService::deleteImage(Event::class, $event, 'banner');
            $data['banner'] = ImageService::StoreImage($request, 'banner', '/Events') ?? ($data['banner'] ?? null);
        }

        if ($request->hasFile('gallery')) {
            $data['gallery'] = ImageService::storeGallery($request, Event::class, $event);
        }

        $event->update($data);
        $event->sponsors()->sync($request->input('sponsors', []));
    }

    private function setStatus($startDate, $endDate = null)
    {
        if($endDate) {
            return $startDate > now() || $endDate > now() ? 'ACTIVE' : 'ARCHIVED';
        }
        return $startDate > now() ? 'ACTIVE' : 'ARCHIVED';
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);
        if ($event) {
            ImageService::deleteStoredImages(Event::class, $event, 'banner');
            $event->delete();
        }
    }

    public function updateHomeImages($request)
    {
        $data = $request->validated();
        $homeImages = HomeImages::first();
        if ($request->hasFile('gallery')) {
            ImageService::deleteStoredImages(HomeImages::class, $homeImages);
            $data['gallery'] = ImageService::storeGallery($request, HomeImages::class, $homeImages);
        }
        $homeImages->update($data);
    }

    public function getHomeImages()
    {
        return HomeImages::first();
    }
}
