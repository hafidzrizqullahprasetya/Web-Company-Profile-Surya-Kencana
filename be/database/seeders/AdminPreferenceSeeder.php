<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminPreference;
use Illuminate\Database\Seeder;

class AdminPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $admins = Admin::all();

            if ($admins->isEmpty()) {
                $this->command->info('No admins found to seed preferences for.');
                return;
            }

            foreach ($admins as $admin) {
                AdminPreference::updateOrCreate(
                    ['admin_id' => $admin->id],
                    [
                        'sidebar_state' => 'open',
                        'menu_order' => [
                            'admin-dashboard' => 0,
                            'admin-product' => 1,
                            'admin-client' => 2,
                            'admin-testimonial' => 3,
                            'admin-vision-mission' => 4,
                            'admin-contact' => 5,
                            'admin-hero' => 6,
                            'admin-company-history' => 7,
                            'admin-settings' => 8,
                            'admin-history' => 9,
                        ],
                    ]
                );
            }

            $this->command->info('Admin preferences seeded successfully!');
        } catch (\Exception $e) {
            $this->command->error('Error seeding admin preferences: ' . $e->getMessage());
        }
    }
}
