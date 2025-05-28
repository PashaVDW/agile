<?php

namespace App\Services;

use App\Mail\AnnouncementMail;
use App\Models\Announcement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AnnouncementService
{
    private MailService $mailService;
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function getAnnouncements()
    {
        return Announcement::query();
    }

    public function store(array $data, $request): Announcement
    {
        $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? null;

        return Announcement::create($data);
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
