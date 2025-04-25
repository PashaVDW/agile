<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'gallery',
        'page_key',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function getGalleryImagePath($image)
    {
        return Storage::url($image);
    }

    public function hasPhotos()
    {
        return !empty($this->gallery);
    }
}
