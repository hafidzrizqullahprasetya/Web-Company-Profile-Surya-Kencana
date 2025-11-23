<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\StorageImageTrait;
use App\Traits\ClearsLandingPageCache;

class OurClient extends Model
{
    use StorageImageTrait, ClearsLandingPageCache;
    
    protected $fillable = [
        'client_name',
        'institution',
        'logo_path',
    ];

    protected $appends = ['logo_url'];

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->buildImageUrl($this->logo_path),
        );
    }
}
