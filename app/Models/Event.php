<?php

namespace App\Models;

use App\Enums\EventCategoryEnum;
use App\Services\TimezoneService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'capacity',
        'date',
        'image',
        'category',
        'payment_link',
    ];

    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class, 'event_sponsors', 'event_ids', 'sponsor_id');
    }

    protected $casts = [
        'category' => EventCategoryEnum::class,
        'date' => 'datetime',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image === null) {
            return 'assets/images/no-image.png';
        }
        return Storage::url($this->image);
    }

    public function getFormattedDateAttribute()
    {
        return $this->date->format('d-m-Y');
    }

    public function getFormattedDateForInputAttribute()
    {
        return $this->date->format('Y-m-d');
    }

    public function getFormattedDateTime($dateTime)
    {
        return TimezoneService::getTimezone($dateTime);
    }

}
