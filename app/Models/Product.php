<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Product extends Model
{
    protected $fillable = ['client_id','name', 'description', 'image_path', 'price'];

    public function client()
    {
        return $this->belongsTo(OurClient::class, 'client_id');
    }   

    public function imagePath(): Attribute{
        return Attribute::make(
            get: fn($value) => asset('storage/products/' . $value),
        );
    }
}
