<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'active'
    ];

    /**
     * Get the events for the sponsor.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
