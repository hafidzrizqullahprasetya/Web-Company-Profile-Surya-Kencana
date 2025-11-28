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

    /**
     * Scope to select only required fields for better performance
     */
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
