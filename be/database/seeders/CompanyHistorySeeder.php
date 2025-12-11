<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyHistorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('company_histories')->insert([
            [
                'id' => 1,
                'tahun' => 2005,
                'judul' => 'Pendirian Perusahaan',
                'deskripsi' => 'Berdiri sebagai bengkel rekayasa di Yogyakarta. Fokus awal pada perbaikan dan modifikasi mesin industri ringan.',
                'created_at' => '2025-11-13 19:42:46',
                'updated_at' => '2025-12-04 07:15:02',
            ],
            [
                'id' => 2,
                'tahun' => 2011,
                'judul' => 'Ekspansi Layanan Custom',
                'deskripsi' => 'Berekspansi ke layanan custom fabrication. Memproduksi mesin semi-otomatis pertama kami untuk industri pengolahan makanan',
                'created_at' => '2025-11-13 19:44:16',
                'updated_at' => '2025-12-04 07:15:02',
            ],
            [
                'id' => 3,
                'tahun' => 2017,
                'judul' => 'Fasilitas Lebih Besar',
                'deskripsi' => 'Pindah ke fasilitas yang lebih besar dan berinvestasi pada teknologi desain 3D (CAD/CAM) dan permesinan CNC untuk meningkatkan presisi.',
                'created_at' => '2025-11-13 19:45:50',
                'updated_at' => '2025-12-04 07:15:02',
            ],
        ]);
    }
}
