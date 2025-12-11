<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('site_settings')->insert([
            'id' => 1,
            'company_name' => 'SURYA KENCANA',
            'company_logo' => 'logos/Asset 5@3x_20251202172150_c6gv1b14.webp',
            'hero_title' => 'MESIN TERBAIK UNTUK INDUSTRI ANDA',
            'hero_subtitle' => 'Jakarta, Indonesia',
            'visi_misi_label' => 'TENTANG KAMI',
            'visi_misi_title' => 'Inovasi Teknik, Presisi Tanpa Kompromi',
            'produk_label' => 'PRODUK KAMI',
            'produk_title' => 'Rekayasa Spesifik untuk Hasil Optimal',
            'clients_label' => 'CLIENT KAMI',
            'clients_title' => 'Dipercaya oleh Industri',
            'riwayat_label' => 'RIWAYAT PERUSAHAAN',
            'riwayat_title' => 'Jejak Langkah PT. Surya Kencana',
            'testimoni_label' => 'TESTIMONIAL',
            'testimoni_title' => 'Apa Kata Mereka Tentang Kami',
            'kontak_label' => 'INFORMASI KONTAK KAMI',
            'kontak_title' => 'JANGAN RAGU MENGHUBUNGI KAMI.',
            'created_at' => '2025-11-07 02:57:57',
            'updated_at' => '2025-12-04 06:59:06',
        ]);
    }
}
