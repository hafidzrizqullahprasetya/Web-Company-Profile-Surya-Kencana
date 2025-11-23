<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\StorageImageTrait;
use App\Traits\ClearsLandingPageCache;

class Hero extends Model
{
    use StorageImageTrait, ClearsLandingPageCache;
    
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
        return $this->buildImageUrl($this->background);
    }

    public function getBackgroundUrlsAttribute()
    {
        if ($this->backgrounds && is_array($this->backgrounds)) {
            return array_map(fn($path) => $this->buildImageUrl($path), $this->backgrounds);
        }
        return [];
    }
}
