<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\StorageImageTrait;
use App\Traits\ClearsLandingPageCache;

class CompanyHistory extends Model
{
    use StorageImageTrait, ClearsLandingPageCache;
    
    protected $fillable = [
        'tahun',
        'judul',
        'deskripsi',
        'image_path',
        'images',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'images' => 'array',
    ];

    protected $appends = ['image_url', 'image_urls'];

    public function getImageUrlAttribute()
    {
        return $this->buildImageUrl($this->image_path);
    }

    public function getImageUrlsAttribute()
    {
        if ($this->images && is_array($this->images)) {
            return array_map(fn($path) => $this->buildImageUrl($path), $this->images);
        }
        return [];
    }
}
