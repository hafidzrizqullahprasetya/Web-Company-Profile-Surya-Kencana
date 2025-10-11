<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Product extends Model
{
    protected $fillable = ['client_id','name', 'description', 'image_path', 'price'];
    protected $appends = ['image_url'];

    public function client()    
    {
        return $this->belongsTo(OurClient::class, 'client_id');
    }   
    
    public function imageUrl(): Attribute{
        return Attribute::make(
            get: fn() => asset('storage/'. $this->image_path),
        );
    }
}
