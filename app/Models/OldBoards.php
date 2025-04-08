<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OldBoards extends Model
{
    protected $fillable = [
        'id',
        'names',
        'term',
        'image'
    ];

    protected $searchable = [
        'names',
        'term',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image === null) {
            return 'assets/images/no-image.png';
        }
        return Storage::url($this->image);
    }

    public function getSearchable()
    {
        return $this->searchable;
    }

}
