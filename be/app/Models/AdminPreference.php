<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPreference extends Model
{
    protected $table = 'admin_preferences';

    protected $fillable = [
        'admin_id',
        'sidebar_state',
        'menu_order',
    ];

    protected $casts = [
        'menu_order' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
