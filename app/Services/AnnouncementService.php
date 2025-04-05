<?php

namespace App\Services;

use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementService
{
    public function store(array $data, $request): Announcement
    {
        $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? null;

        return Announcement::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);
    }

    public function update(Announcement $announcement, array $data, $request): Announcement
    {
        if ($request->hasFile('image')) {
            ImageService::deleteImage(Announcement::class, $announcement, 'image');
            $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? ($data['image'] ?? null);
        }

        $announcement->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);

        return $announcement;
    }

    public function delete(Announcement $announcement): void
    {
        ImageService::deleteImage(Announcement::class, $announcement, 'image');
        $announcement->delete();
    }
}
