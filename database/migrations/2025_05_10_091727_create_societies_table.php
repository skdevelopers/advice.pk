<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migration to create the 'societies' table.
 *
 * This table stores real estate societies linked to cities and users,
 * including their SEO metadata, images, and content related to different property types.
 */
class CreateSocietiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('societies', function (Blueprint $table) {
            $table->id(); // Big increment primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Creator of the record
            $table->foreignId('city_id')->constrained()->onDelete('cascade'); // City relation

            $table->string('name', 255)->index(); // Society name
            $table->string('slug', 255)->unique(); // SEO-friendly URL

            // Meta-information stored as JSON for extensibility
            $table->json('meta_data')->nullable(); // {title, keywords, description}
            $table->json('map_data')->nullable();  // {title, keywords, description, image}

            // Details
            $table->longText('overview')->nullable(); // Society overview
            $table->longText('detail')->nullable();   // General detailed description

            // Property types (flags) and their respective content
            $table->boolean('has_residential_plots')->default(false);
            $table->boolean('has_commercial_plots')->default(false);
            $table->boolean('has_houses')->default(false);
            $table->boolean('has_apartments')->default(false);
            $table->boolean('has_farm_houses')->default(false);
            $table->boolean('has_shop')->default(false);

            // JSON column to store detailed info for each type
            $table->json('property_types')->nullable();
            /**
             * Example structure:
             * {
             *   "commercial": {
             *     "title": "...",
             *     "keywords": "...",
             *     "description": "...",
             *     "detail": "..."
             *   },
             *   "houses": { ... },
             *   ...
             * }
             */
            $table->integer('created_by');
            $table->string('status', 20)->default('enabled')->index(); // Status (enabled/disabled)
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societies');
    }
}
