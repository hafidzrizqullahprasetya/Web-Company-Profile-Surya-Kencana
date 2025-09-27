<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 5; $i++) {
            Testimonial::create([
                'client_name' => fake()->name(),
                'institution' => fake()->company(),
                'feedback' => fake()->paragraph(),
                'date' => fake()->date(),
            ]);
        }
    }
}
