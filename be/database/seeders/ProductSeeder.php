<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\OurClient;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 5; $i++) {
            Product::create([
                'client_id' => OurClient::inRandomOrder()->first()->id,
                'name' => fake()->word(),
                'description' => fake()->paragraph(),
                'image_path' => fake()->imageUrl(200, 200, 'technics', true),
                'price' => fake()->randomFloat(2, 10, 1000),
                
            ]);
        }
    }
}
