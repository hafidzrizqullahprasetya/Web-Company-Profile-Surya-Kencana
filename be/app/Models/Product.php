<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\StorageImageTrait;

class Product extends Model
{
    use StorageImageTrait;

    protected $fillable = [
        "client_id",
        "name",
        "description",
        "image_path",
        "price",
        "hide_price",
        "images",
        "order",
    ];
    protected $appends = ["image_url", "image_urls"];
    protected $casts = [
        "images" => "array",
    ];

    public function client()
    {
        return $this->belongsTo(OurClient::class, "client_id");
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->buildImageUrl(
                $this->image_path,
                config("performance.image_check.skip_existence_check", true),
            ),
        );
    }

    public function getImageUrlsAttribute()
    {
        if ($this->images && is_array($this->images)) {
            return array_map(
                fn($path) => $this->buildImageUrl(
                    $path,
                    config(
                        "performance.image_check.skip_existence_check",
                        true,
                    ),
                ),
                $this->images,
            );
        }
        return [];
    }

    public function toArray()
    {
        $data = parent::toArray();

        if (!isset($data["client"])) {
            $data["image_url"] =
                isset($this->image_path) && !is_null($this->image_path)
                    ? $this->image_url
                    : null;

            $data["image_urls"] =
                isset($this->images) && is_array($this->images)
                    ? $this->image_urls
                    : [];
        }

        return $data;
    }

    public function scopePerformanceSelect($query)
    {
        return $query->select(
            'id',
            'client_id',
            'name',
            'description',
            'image_path',
            'price',
            'hide_price',
            'images',
            'order',
            'created_at',
            'updated_at'
        );
    }
}
