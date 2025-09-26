<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurClient extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class, 'client_id');//
    }
    
}
