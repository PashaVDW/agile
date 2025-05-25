<?php

namespace App\Services;

use App\Events\EventCreated;
use App\Jobs\CreateGoogleCalendarEvent;
use App\Jobs\UpdateGoogleCalendarEvent;
use App\Models\Event;
use App\Models\Gallery;

class EventService
{
    public function getEvents()
    {
        return Event::query()
            ->orderBy('status', 'ASC')
            ->orderBy('start_date', 'DESC')
            ->with('sponsors');
    }

    public function getEvent($id)
    {
        return Event::find($id)->load('sponsors');
    }

    public function storeEvent($request)
    {
        $data = $request->validated();
        $data['is_open'] = $request->input('is_open', false) === 'on';
        $data['banner'] = ImageService::StoreImage(
            $request,
            'banner',
            '/Events'
        ) ?? ($data['banner'] ?? null);
        $data['status'] = $this->setStatus($data['start_date'], $data['end_date']);

        $event = Event::create($data);

        dispatch_sync(new CreateGoogleCalendarEvent(
            $data['start_date'],
            $data['end_date'],
            $data['title'],
            $data['category'],
            $event->id
        ));

        $event->sponsors()->sync($request->input('sponsors', []));

        $discordSettings = $request->input('discord') ?? null;

        event(new EventCreated($event, $discordSettings));
        return $event;
    }

    public function updateEvent($request, $id)
    {
        $data = $request->validated();
        $data['is_open'] = $request->input('is_open', false) === 'on';
        $data['status'] = $this->setStatus($data['start_date'], $data['end_date']);
        $event = Event::find($id);

        if ($request->hasFile('banner')) {
            ImageService::deleteImage(Event::class, $event, 'banner');
            $data['banner'] = ImageService::StoreImage(
                $request,
                'banner',
                '/Events'
            ) ?? ($data['banner'] ?? null);
        }

        $event->update($data);

        dispatch_sync(new UpdateGoogleCalendarEvent(
            $data['start_date'],
            $data['end_date'],
            $data['title'],
            $data['category'],
            $event->id
        ));

        $event->sponsors()->sync($request->input('sponsors', []));

        return $event;
    }

    private function setStatus($startDate, $endDate = null)
    {
        if ($endDate) {
            return $startDate > now() || $endDate > now() ? 'ACTIVE' : 'ARCHIVED';
        }
        return $startDate > now() ? 'ACTIVE' : 'ARCHIVED';
    }

    public function deleteEvent($id)
    {
        $event = Event::find($id);
        if ($event) {
            ImageService::deleteStoredImages(Event::class, $event, 'banner');
            if ($event->google_calendar_event_id) {
                try {
                    $googleEvent = \Spatie\GoogleCalendar\Event::find(
                        $event->google_calendar_event_id
                    );
                    if ($googleEvent) {
                        $googleEvent->delete();
                    }
                } catch (\Exception $e) {
                    // Silently handle the error
                }
            }
            $event->delete();
        }
    }

    public function getHomeImages()
    {
        return Gallery::where('page_key', 'home')->first();
    }

    public function registerUser($request, $id)
    {
        $event = Event::find($id);
        if ($event) {
            $event->registeredUsers()->attach($request->user()->id);
        }
    }

    public function unregisterUser($request, $id)
    {
        $event = Event::find($id);
        if ($event) {
            $event->registeredUsers()->detach($request->user()->id);
        }
    }
}
