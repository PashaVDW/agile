<?php

namespace App\Models;

use App\Enums\ActiveTypeEnum;
use App\Enums\EventCategoryEnum;
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
        'banner',
        'category',
        'payment_link',
        'gallery',
        'status',
        'start_date',
        'end_date',
        'location',
    ];

    protected $searchable = [
        'title',
        'start_date',
        'location',
        'status',
        'category',
    ];

    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class, 'event_sponsors', 'event_id', 'sponsor_id');
    }

    protected $casts = [
        'category' => EventCategoryEnum::class,
        'start_date' => 'datetime',
        'status' => ActiveTypeEnum::class,
        'gallery' => 'array',
        'end_date' => 'datetime',
    ];

    public function getBannerUrlAttribute()
    {
        if ($this->banner === null) {
            return 'assets/images/logo-black.svg';
        }
        return Storage::url($this->banner);
    }

    public function getGalleryImagePath($image)
    {
        return Storage::url($image);
    }

    public function hasPhotos()
    {
        return !empty($this->gallery);
    }

    public function getDecodedPhotos() {
        return json_decode($this->gallery);
    }

    public function getFormattedDate($date)
    {
        if ($date === null) {
            return null;
        }
        return $date->format('H:i d-m-Y');
    }

    public function getFormattedDateForInput($date)
    {
        if ($date === null) {
            return null;
        }
        return $date->format('Y-m-d H:i');
    }

    public function getSearchable()
    {
        return $this->searchable;
    }
}
