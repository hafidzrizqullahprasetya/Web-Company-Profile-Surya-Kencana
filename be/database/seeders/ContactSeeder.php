<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            "address" => "Jl Mulyosari, Tumut, Sumbersari, Kec. Moyudan, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55563",
            "phone" => "088902947368",
            "email" => "suryakencana@gmail.com",
            "map_url" => "https://maps.app.goo.gl/uwCvY1VCJAVK4mANA/"
        ]);
        
    }
}
