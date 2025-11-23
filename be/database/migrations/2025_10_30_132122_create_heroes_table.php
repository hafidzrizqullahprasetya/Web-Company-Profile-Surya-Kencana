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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('background')->nullable();
            $table->string('location', 255)->default('Jakarta, Indonesia');
            $table->string('title', 500)->default('MESIN TERBAIK UNTUK INDUSTRI ANDA');
            $table->integer('machines')->default(500);
            $table->integer('clients')->default(200);
            $table->integer('customers')->default(5000);
            $table->integer('experience_years')->default(15);
            $table->integer('trust_years')->default(20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
