<?php

namespace App\Jobs;

use App\Services\GoogleCalendarService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateGoogleCalendarEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

    private string $startDate;
    private string $endDate;
    private string $title;
    private string $category;
    private int $eventId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $startDate, string $endDate, string $title, string $category, int $eventId)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->title = $title;
        $this->category = $category;
        $this->eventId = $eventId;
    }

    /**
     * Execute the job.
     */
    public function handle(GoogleCalendarService $googleCalendarService)
    {
        $googleCalendarService->createEvent(
            $this->startDate,
            $this->endDate,
            $this->title,
            $this->category,
            $this->eventId
        );
    }
}
