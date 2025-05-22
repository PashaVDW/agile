<?php

namespace App\Services;

use App\Mail\AnnouncementMail;
use App\Mail\NotifactionMail;
use App\Models\Announcement;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendAnnouncementMail(Announcement $ann, string|array $to) : void
    {
        Mail::to($to)->send(new NotifactionMail([
            'subject' => "nieuwe melding van concat: {$ann->title}",
            'title' => $ann->title,
            'id' => $ann->id,
            'body' => $ann->description,
            'imageUrl' => $ann->banner ? $ann->banner_url : null,
            'btnText' => 'Bekijk op de website',
            'btnUrl' => route('user.announcement.show', $ann),
            'type' => 'announcement',
        ]));
    }
    public function sendEvent(Event $event, string|array $to): void
    {
        $price = $event->price ? "Prijs: €{$event->price}\n" : '';
        $dates = "Datum: {$event->formatted_date}\n";

        Mail::to($to)->send(new NotifactionMail([
            'subject' => " Nieuw evenement van concat: {$event->title}",
            'title' => $event->title,
            'id' => $event->id,
            'body' => "{$event->description}\n\n{$price}{$dates}",
            'imageUrl' => $event->banner ? $event->banner_url : null,
            'btnText' => 'Meer informatie & tickets',
            'btnUrl' => route('user.event.show', $event),
            'type' => 'event',
        ]));
    }
}
