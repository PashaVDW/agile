<?php

namespace App\Services;

use App\Jobs\ProcessImageUpload;
use App\Models\Event;

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
        $data['banner'] = ImageService::StoreImage($request, 'banner', 'Events') ?? ($data['banner'] ?? null);
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
            $data['banner'] = ImageService::StoreImage($request, 'banner', 'Events') ?? ($data['banner'] ?? null);
        }

        if ($request->hasFile('gallery')) {
            ImageService::deleteImages(Event::class, $event);
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $filePath = $file->storeAs('images/gallery', $file->getClientOriginalName(), 'public');
                ProcessImageUpload::dispatch($filePath, $file->getClientOriginalName(), 'images/gallery');
                $galleryPaths[] = 'images/gallery/' . $file->getClientOriginalName();
            }
            $data['gallery'] = json_encode($galleryPaths);
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
            $this->deleteImages($event);
            $event->delete();
        }
    }

    private function deleteImages($event) {
        if ($event->banner) {
            ImageService::deleteImage(Event::class, $event, 'banner');
        }
        if ($event->gallery) {
            ImageService::deleteImages(Event::class, $event);
        }
    }

    public function getRandomEvent()
    {
        return Event::whereNotNUll('gallery')
            ->inRandomOrder()
            ->first();
    }
}
