<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BoardMember extends Model
{
    protected $fillable = [
        'id',
        'name',
        'role',
        'description',
        'image'
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image === null) {
            return 'assets/images/no-image.png';
        }
        return Storage::url($this->image);
    }
}
