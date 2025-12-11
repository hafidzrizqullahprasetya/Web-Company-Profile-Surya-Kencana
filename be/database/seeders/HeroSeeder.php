<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('heroes')->insert([
            'id' => 1,
            'background' => json_encode([
                "heroes/72cf5923-626d-4197-a7bb-c2872132f4df.webp",
                "heroes/Food Truck_20251205045508_szx6lglw.webp"
            ]),
            'location' => 'Yogyakarta, Indonesia',
            'title' => 'Mesin Custom untuk Kebutuhan Industri Anda',
            'machines' => 500,
            'clients' => 100,
            'customers' => 5000,
            'experience_years' => 80,
            'trust_years' => 20,
            'created_at' => '2025-11-07 06:07:13',
            'updated_at' => '2025-12-05 07:20:49',
        ]);
    }
}
