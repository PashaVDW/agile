<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = ['logo', 'name', 'description', 'active'];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_sponsor');
    }
}
