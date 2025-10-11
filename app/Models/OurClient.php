<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class OurClient extends Model
{
    protected $fillable = ['client_name', 'institution', 'logo_path'];
    protected $appends = ['logo_url'];

    public function products()
    {
        return $this->hasMany(Product::class, 'client_id');
    }

    public function logoUrl(): Attribute{
        return Attribute::make(
            get: fn() => asset('storage/'. $this->logo_path),
        );
    }
}
