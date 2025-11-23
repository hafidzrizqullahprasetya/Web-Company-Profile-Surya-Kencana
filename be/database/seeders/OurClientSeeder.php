<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OurClient;

class OurClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 5; $i++) {    
            OurClient::create([
                'client_name' => fake()->name(),
                'institution' => fake()->company(),
                'logo_path' => fake()->imageUrl(100, 100, 'business', true),
            ]);
        }
    }
}
