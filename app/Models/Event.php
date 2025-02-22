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
        'image',
        'category',
        'payment_link',

    ];

    protected $casts = [
        'category' => EventCategoryEnum::class
    ];

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image);
    }
}
