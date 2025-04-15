<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeImages extends Model
{
    protected $table = 'home_images';

    protected $fillable = [
        'gallery',
    ];

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

}
