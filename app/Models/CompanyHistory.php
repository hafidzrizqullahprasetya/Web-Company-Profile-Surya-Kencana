<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyHistory extends Model
{
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
        if ($this->image_path) {
            // Check if it's already a full URL
            if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
                return $this->image_path;
            }
            // Otherwise, return storage URL
            return asset('storage/' . $this->image_path);
        }
        return null;
    }

    public function getImageUrlsAttribute()
    {
        if ($this->images && is_array($this->images)) {
            return array_map(function ($path) {
                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    return $path;
                }
                return asset('storage/' . $path);
            }, $this->images);
        }
        return [];
    }
}
