<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisionMission;

class VisionMissionSeeder extends Seeder
{
    public function run(): void
    {
        VisionMission::create([
            'vision' => fake()->sentence(3),
            'mission' => fake()->sentence(3),
        ]);
    }
}
