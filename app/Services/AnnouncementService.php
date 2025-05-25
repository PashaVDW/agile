<?php

namespace App\Services;

use App\Events\AnnouncementCreated;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class AnnouncementService
{
    public function getAnnouncements(): Builder
    {
        return Announcement::query();
    }

    public function store(array $data, $request): Announcement
    {
        $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? null;
        $announcement = Announcement::create($data);
        $discordSettings = $request->input('discord') ?? null;

        event(new AnnouncementCreated($announcement, $discordSettings));
        return $announcement;
    }


    public function update(Announcement $announcement, array $data, $request): Announcement
    {
        if ($request->hasFile('image')) {
            ImageService::deleteImage(Announcement::class, $announcement, 'image');
            $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? ($data['image'] ?? null);
        }

        $announcement->update($data);

        return $announcement;
    }

    public function delete(Announcement $announcement): void
    {
        ImageService::deleteImage(Announcement::class, $announcement, 'image');
        $announcement->delete();
    }

    public function getPaginatedPublicAnnouncements(int $perPage = 10)
    {
        return Announcement::query()
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
}
