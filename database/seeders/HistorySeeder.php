<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\History;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 5; $i++) {
            History::create([
                'title' => fake()->title(),
                'description' => fake()->paragraph(),
                'year' => fake()->date('Y-m-d'),
            ]);
        }
    }
}
