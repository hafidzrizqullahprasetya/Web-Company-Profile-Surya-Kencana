<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\StorageImageTrait;
use App\Traits\ClearsLandingPageCache;

class Product extends Model
{
    use StorageImageTrait, ClearsLandingPageCache;
    
    protected $fillable = ['client_id','name', 'description', 'image_path', 'price', 'images'];
    protected $appends = ['image_url', 'image_urls'];
    protected $casts = [
        'images' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(OurClient::class, 'client_id');
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->buildImageUrl($this->image_path),
        );
    }

    public function getImageUrlsAttribute()
    {
        if ($this->images && is_array($this->images)) {
            return array_map(fn($path) => $this->buildImageUrl($path), $this->images);
        }
        return [];
    }
}
