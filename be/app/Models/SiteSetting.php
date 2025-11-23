<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\StorageImageTrait;
use App\Traits\ClearsLandingPageCache;

class SiteSetting extends Model
{
    use StorageImageTrait, ClearsLandingPageCache;
    
    protected $fillable = [
        'company_name',
        'company_logo',
        'hero_title',
        'hero_subtitle',
        'visi_misi_label',
        'visi_misi_title',
        'produk_label',
        'produk_title',
        'clients_label',
        'clients_title',
        'riwayat_label',
        'riwayat_title',
        'testimoni_label',
        'testimoni_title',
        'kontak_label',
        'kontak_title',
    ];

    protected $appends = ['company_logo_url'];

    public function getCompanyLogoUrlAttribute()
    {
        return $this->buildImageUrl($this->company_logo);
    }
}
