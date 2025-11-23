<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ClearsLandingPageCache;

class Testimonial extends Model
{
    use ClearsLandingPageCache;

    protected $fillable = [
        'client_name',
        'institution',
        'feedback',
        'date',
    ];
}
