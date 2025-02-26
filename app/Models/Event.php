<?php

namespace App\Models;

use App\Enums\EventCategoryEnum;
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
    ];

    protected $casts = [
        'category' => EventCategoryEnum::class,
        'gallery' => 'array',
    ];

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image);
    }

    public function hasPhotos()
    {
        return !empty($this->gallery);
    }

    public function getDecodedPhotos() {
        return json_decode($this->gallery);
    }
}
