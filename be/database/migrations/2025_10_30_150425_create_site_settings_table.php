<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Company Info
            $table->string('company_name')->default('SURYA KENCANA');
            $table->string('company_logo')->nullable();

            // Section Titles - Hero
            $table->string('hero_title', 500)->default('MESIN TERBAIK UNTUK INDUSTRI ANDA');
            $table->string('hero_subtitle')->default('Jakarta, Indonesia');

            // Section Titles - Visi Misi
            $table->string('visi_misi_label')->default('TENTANG KAMI');
            $table->string('visi_misi_title', 500)->default('CREATE YOUR STORY IN A PLACE WHERE DREAMS AND REALITY MERGE.');

            // Section Titles - Produk
            $table->string('produk_label')->default('PRODUK KAMI');
            $table->string('produk_title', 500)->default('OUR MACHINE PRODUCTS SPECIFICATIONS.');

            // Section Titles - Clients
            $table->string('clients_label')->default('Our Partners');
            $table->string('clients_title', 500)->default('Trusted Clients');

            // Section Titles - Riwayat
            $table->string('riwayat_label')->default('RIWAYAT PERUSAHAAN');
            $table->string('riwayat_title', 500)->default('PERJALANAN KAMI SELAMA INI.');

            // Section Titles - Testimoni
            $table->string('testimoni_label')->default('TESTIMONIAL');
            $table->string('testimoni_title', 500)->default('PENGALAMAN PELANGGAN KAMI.');

            // Section Titles - Kontak
            $table->string('kontak_label')->default('HUBUNGI KAMI');
            $table->string('kontak_title', 500)->default('JANGAN RAGU MENGHUBUNGI KAMI.');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
