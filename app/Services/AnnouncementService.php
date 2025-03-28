<?php

namespace App\Services;

use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementService
{
    public function store(array $data, $request): Announcement
    {
        $data['image'] = ImageService::StoreImage($request, 'image', '/announcements');

        return Announcement::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);
    }

    public function update(Announcement $announcement, array $data, $request): Announcement
    {
        if ($request->hasFile('image')) {
            if ($announcement->image && Storage::disk('public')->exists($announcement->image)) {
                Storage::disk('public')->delete($announcement->image);
            }

            $data['image'] = ImageService::StoreImage($request, 'image', '/announcements');
        } else {
            $data['image'] = $announcement->image;
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
        if ($announcement->image && Storage::disk('public')->exists($announcement->image)) {
            Storage::disk('public')->delete($announcement->image);
        }

        $announcement->delete();
    }
}
