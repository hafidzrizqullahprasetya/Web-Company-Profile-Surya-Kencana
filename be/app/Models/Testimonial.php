<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name',
        'institution',
        'feedback',
        'date',
        'order',
    ];

    public function scopePerformanceSelect($query)
    {
        return $query->select(
            "id",
            "client_name",
            "institution",
            "feedback",
            "date",
            "created_at",
            "updated_at"
        );
    }
}
