<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventService
{
    public function getEvents($order = 'ASC')
    {
        return Event::query()->orderBy('status', $order)->orderBy('date', $order);
    }

    public function getEvent($id)
    {
        return Event::find($id);
    }

    public function storeEvent($request)
    {
        $data = $request->validated();
        $data['banner'] = ImageService::StoreImage($request, 'banner') ?? ($data['banner'] ?? null);
        Event::create($data);
    }

    public function updateEvent($request, $id)
    {
        $data = $request->validated();
        if ($request->hasFile('banner')) {
            $data['banner'] = ImageService::StoreImage($request, 'banner') ?? ($data['banner'] ?? null);
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $filePath = 'images/gallery/' . $file->getClientOriginalName();
                if (!Storage::disk('public')->exists($filePath)) {
                    $filePath = $file->storeAs('images/gallery', $file->getClientOriginalName(), 'public');
                }
                $galleryPaths[] = $filePath;
            }
            $data['gallery'] = json_encode($galleryPaths);
        }

        Event::find($id)->update($data);
    }

    public function deleteEvent($id)
    {
        Event::destroy($id);
    }
}
