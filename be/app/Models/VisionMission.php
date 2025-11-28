<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ClearsLandingPageCache;

class VisionMission extends Model
{
    use ClearsLandingPageCache;

    protected $fillable = ['vision', 'mission'];

    /**
     * Scope to select only required fields for better performance
     */
    public function scopePerformanceSelect($query)
    {
        return $query->select(
            'id',
            'vision',
            'mission',
            'created_at',
            'updated_at'
        );
    }
}
