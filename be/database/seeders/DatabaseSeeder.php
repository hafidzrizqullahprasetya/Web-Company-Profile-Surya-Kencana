<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ContactSeeder::class,
            OurClientSeeder::class,
            ProductSeeder::class,
            SuperAdminSeeder::class,
            TestimonialSeeder::class,
            VisionMissionSeeder::class,
        ]);
    }
}
