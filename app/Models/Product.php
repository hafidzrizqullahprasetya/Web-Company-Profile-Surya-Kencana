<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Product extends Model
{
    protected $fillable = ['client_id','name', 'description', 'image_path', 'price', 'images'];
    protected $appends = ['image_url', 'image_urls'];
    protected $casts = [
        'images' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(OurClient::class, 'client_id');
    }

    public function imageUrl(): Attribute{
        return Attribute::make(
            get: fn() => $this->image_path ? asset('storage/'. $this->image_path) : null,
        );
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
