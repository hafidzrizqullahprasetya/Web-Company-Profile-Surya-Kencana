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
        // Indexes for our_clients table
        Schema::table('our_clients', function (Blueprint $table) {
            $table->index(['client_name'], 'idx_clients_name');
            $table->index(['institution'], 'idx_clients_institution');
            $table->index(['created_at'], 'idx_clients_created_at');
        });

        // Indexes for testimonials table
        Schema::table('testimonials', function (Blueprint $table) {
            $table->index(['date'], 'idx_testimonials_date');
            $table->index(['client_name'], 'idx_testimonials_client_name');
            $table->index(['institution'], 'idx_testimonials_institution');
            $table->index(['created_at'], 'idx_testimonials_created_at');
        });

        // Indexes for company_histories table
        Schema::table('company_histories', function (Blueprint $table) {
            $table->index(['tahun'], 'idx_company_histories_year');
            $table->index(['created_at'], 'idx_company_histories_created_at');
        });

        // Indexes for heroes table
        Schema::table('heroes', function (Blueprint $table) {
            $table->index(['created_at'], 'idx_heroes_created_at');
            $table->index(['updated_at'], 'idx_heroes_updated_at');
        });

        // Indexes for site_settings table
        Schema::table('site_settings', function (Blueprint $table) {
            $table->index(['updated_at'], 'idx_site_settings_updated_at');
        });

        // Indexes for vision_missions table
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->index(['updated_at'], 'idx_vision_missions_updated_at');
        });

        // Indexes for contacts table
        Schema::table('contacts', function (Blueprint $table) {
            $table->index(['updated_at'], 'idx_contacts_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes for our_clients table
        Schema::table('our_clients', function (Blueprint $table) {
            $table->dropIndex(['idx_clients_name']);
            $table->dropIndex(['idx_clients_institution']);
            $table->dropIndex(['idx_clients_created_at']);
        });

        // Drop indexes for testimonials table
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['idx_testimonials_date']);
            $table->dropIndex(['idx_testimonials_client_name']);
            $table->dropIndex(['idx_testimonials_institution']);
            $table->dropIndex(['idx_testimonials_created_at']);
        });

        // Drop indexes for company_histories table
        Schema::table('company_histories', function (Blueprint $table) {
            $table->dropIndex(['idx_company_histories_year']);
            $table->dropIndex(['idx_company_histories_created_at']);
        });

        // Drop indexes for heroes table
        Schema::table('heroes', function (Blueprint $table) {
            $table->dropIndex(['idx_heroes_created_at']);
            $table->dropIndex(['idx_heroes_updated_at']);
        });

        // Drop indexes for site_settings table
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropIndex(['idx_site_settings_updated_at']);
        });

        // Drop indexes for vision_missions table
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->dropIndex(['idx_vision_missions_updated_at']);
        });

        // Drop indexes for contacts table
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['idx_contacts_updated_at']);
        });
    }
};
