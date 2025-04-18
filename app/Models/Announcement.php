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

    public function getImageUrlAttribute()
    {
        if ($this->image == null) {
            return null;
        }

        return asset('storage/' . $this->image);
    }
}
