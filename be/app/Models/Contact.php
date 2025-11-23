<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ClearsLandingPageCache;

class Contact extends Model
{
    use ClearsLandingPageCache;

    protected $fillable = [
        'address',
        'phone',
        'email',
        'map_url',
    ];
}
