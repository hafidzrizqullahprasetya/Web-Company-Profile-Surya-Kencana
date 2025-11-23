<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ClearsLandingPageCache;

class VisionMission extends Model
{
    use ClearsLandingPageCache;

    protected $fillable = ['vision', 'mission'];
}
