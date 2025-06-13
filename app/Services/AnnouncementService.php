<?php

namespace App\Services;

use App\Events\AnnouncementCreated;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use App\Mail\AnnouncementMail;
use Illuminate\Support\Facades\Mail;

class AnnouncementService
{
    private MailService $mailService;
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function getAnnouncements(): Builder
    {
        return Announcement::query();
    }

    public function store(array $data, $request)
    {
        $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? null;
        $announcement = Announcement::create($data);
        $discordSettings = $request->input('discord') ?? null;

        DiscordService::notifyDiscord($announcement, $discordSettings, 'announcement');

        $this->sendAnnouncementEmailToSubscribers($announcement);

        return $announcement;
    }

    private function sendAnnouncementEmailToSubscribers(Announcement $announcement)
    {
        $subscribedUsers = \App\Models\User::where('notification_preferences->announcements', true)->get();

        if ($subscribedUsers->isEmpty()) {
            return;
        }

        $emails = $subscribedUsers->pluck('email')->toArray();

        $this->mailService->sendAnnouncementMail($announcement, $emails);
    }

    public function update(Announcement $announcement, array $data, $request)
    {
        if ($request->hasFile('image')) {
            ImageService::deleteImage(Announcement::class, $announcement, 'image');
            $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? ($data['image'] ?? null);
        }

        $announcement->update($data);
        $discordSettings = $request->input('discord') ?? null;

        event(new AnnouncementCreated($announcement, $discordSettings));
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
