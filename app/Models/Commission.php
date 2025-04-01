<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Commission extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
