<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'background',
        'backgrounds',
        'location',
        'title',
        'machines',
        'clients',
        'customers',
        'experience_years',
        'trust_years',
    ];

    protected $casts = [
        'backgrounds' => 'array',
    ];

    protected $appends = ['background_url', 'background_urls'];

    public function getBackgroundUrlAttribute()
    {
        if ($this->background) {
            // If it's already a full URL (http/https), return as is
            if (filter_var($this->background, FILTER_VALIDATE_URL)) {
                return $this->background;
            }
            // Otherwise, return storage URL
            return asset('storage/' . $this->background);
        }
        return null;
    }

    public function getBackgroundUrlsAttribute()
    {
        if ($this->backgrounds && is_array($this->backgrounds)) {
            return array_map(function ($path) {
                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    return $path;
                }
                return asset('storage/' . $path);
            }, $this->backgrounds);
        }
        return [];
    }
}
