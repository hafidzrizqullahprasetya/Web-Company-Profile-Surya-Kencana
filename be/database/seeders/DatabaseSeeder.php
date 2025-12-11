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
            ContactSeeder::class,
            HeroSeeder::class,
            VisionMissionSeeder::class,
            SiteSettingSeeder::class,
            OurClientSeeder::class,
            ProductSeeder::class,
            CompanyHistorySeeder::class,
            TestimonialSeeder::class,
            SuperAdminSeeder::class,
        ]);
    }
}
