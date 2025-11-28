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

    /**
     * Scope to select only required fields for better performance
     */
    public function scopePerformanceSelect($query)
    {
        return $query->select(
            'id',
            'address',
            'phone',
            'email',
            'map_url',
            'created_at',
            'updated_at'
        );
    }
}
