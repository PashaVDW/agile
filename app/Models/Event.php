<?php

namespace App\Models;

use App\Enums\ActiveTypeEnum;
use App\Enums\EventCategoryEnum;
use App\Services\TimezoneService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'capacity',
        'date',
        'banner',
        'category',
        'payment_link',
        'gallery',
        'status',
    ];

    protected $casts = [
        'category' => EventCategoryEnum::class,
        'date' => 'datetime',
        'status' => ActiveTypeEnum::class,
        'gallery' => 'array',
    ];

    public function getBannerUrlAttribute()
    {
        if ($this->banner === null) {
            return 'assets/images/no-image.png';
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
