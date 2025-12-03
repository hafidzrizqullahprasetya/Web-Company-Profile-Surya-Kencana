<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\StorageImageTrait;

class CompanyHistory extends Model
{
    use StorageImageTrait;

    protected $fillable = [
        'tahun',
        'judul',
        'deskripsi',
        'image_path',
        'images',
        'order',
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

    public function scopePerformanceSelect($query)
    {
        return $query->select(
            'id',
            'tahun',
            'judul',
            'deskripsi',
            'image_path',
            'images',
            'order',
            'created_at',
            'updated_at'
        );
    }
}
