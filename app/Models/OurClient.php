<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OurClient extends Model
{
    protected $fillable = [
        'client_name',
        'institution',
        'logo_path',
    ];

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->logo_path ? (str_starts_with($this->logo_path, 'http') ? $this->logo_path : asset('storage/' . $this->logo_path)) : null,
        );
    }
}
