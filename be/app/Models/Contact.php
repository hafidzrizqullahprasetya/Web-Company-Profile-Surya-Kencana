<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'email',
        'map_url',
        'map_location_name',
    ];

    public function scopePerformanceSelect($query)
    {
        return $query->select(
            'id',
            'address',
            'phone',
            'email',
            'map_url',
            'map_location_name',
            'created_at',
            'updated_at'
        );
    }
}
