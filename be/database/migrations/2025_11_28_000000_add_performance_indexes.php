<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add indexes to improve query performance
     */
    public function up(): void
    {
        // Products table indexes
        Schema::table('products', function (Blueprint $table) {
            $table->index('client_id', 'products_client_id_index');
            $table->index('created_at', 'products_created_at_index');
            $table->index('updated_at', 'products_updated_at_index');
        });

        // Our Clients table indexes
        Schema::table('our_clients', function (Blueprint $table) {
            $table->index('client_name', 'our_clients_client_name_index');
            $table->index('created_at', 'our_clients_created_at_index');
            $table->index('updated_at', 'our_clients_updated_at_index');
        });

        // Testimonials table indexes
        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('date', 'testimonials_date_index');
            $table->index('created_at', 'testimonials_created_at_index');
            $table->index('updated_at', 'testimonials_updated_at_index');
        });

        // Company Histories table indexes
        Schema::table('company_histories', function (Blueprint $table) {
            $table->index('tahun', 'company_histories_tahun_index');
            $table->index('created_at', 'company_histories_created_at_index');
            $table->index('updated_at', 'company_histories_updated_at_index');
        });

        // Admins table indexes
        Schema::table('admins', function (Blueprint $table) {
            $table->index('username', 'admins_username_index');
            $table->index('created_at', 'admins_created_at_index');
        });

        // Heroes table indexes
        Schema::table('heroes', function (Blueprint $table) {
            $table->index('updated_at', 'heroes_updated_at_index');
        });

        // Vision Missions table indexes
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->index('updated_at', 'vision_missions_updated_at_index');
        });

        // Contacts table indexes
        Schema::table('contacts', function (Blueprint $table) {
            $table->index('updated_at', 'contacts_updated_at_index');
        });

        // Site Settings table indexes
        Schema::table('site_settings', function (Blueprint $table) {
            $table->index('updated_at', 'site_settings_updated_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_client_id_index');
            $table->dropIndex('products_created_at_index');
            $table->dropIndex('products_updated_at_index');
        });

        // Our Clients table
        Schema::table('our_clients', function (Blueprint $table) {
            $table->dropIndex('our_clients_client_name_index');
            $table->dropIndex('our_clients_created_at_index');
            $table->dropIndex('our_clients_updated_at_index');
        });

        // Testimonials table
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex('testimonials_date_index');
            $table->dropIndex('testimonials_created_at_index');
            $table->dropIndex('testimonials_updated_at_index');
        });

        // Company Histories table
        Schema::table('company_histories', function (Blueprint $table) {
            $table->dropIndex('company_histories_tahun_index');
            $table->dropIndex('company_histories_created_at_index');
            $table->dropIndex('company_histories_updated_at_index');
        });

        // Admins table
        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex('admins_username_index');
            $table->dropIndex('admins_created_at_index');
        });

        // Heroes table
        Schema::table('heroes', function (Blueprint $table) {
            $table->dropIndex('heroes_updated_at_index');
        });

        // Vision Missions table
        Schema::table('vision_missions', function (Blueprint $table) {
            $table->dropIndex('vision_missions_updated_at_index');
        });

        // Contacts table
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_updated_at_index');
        });

        // Site Settings table
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropIndex('site_settings_updated_at_index');
        });
    }
};
