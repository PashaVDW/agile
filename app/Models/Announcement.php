<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    protected $searchable = [
        'title',
        'description',
    ];

    public function getSearchable()
    {
        return $this->searchable;
    }

    public function getBannerUrlAttribute()
    {
        if ($this->image === null) {
            return 'assets/images/logo-black.svg';
        }

        return 'storage/' . $this->image;
    }

    public function getBannerAttribute()
    {
        return $this->image !== null;
    }
}
