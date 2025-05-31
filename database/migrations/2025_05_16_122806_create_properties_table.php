<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // Foreign relations
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('society_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_sector_id')->nullable()->constrained('sub_sectors')->onDelete('set null');

            // Core details
            $table->string('purpose'); // sale, rent
            $table->string('property_type')->nullable(); // home, plot, apartment, etc.
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // SEO fields
            $table->text('keywords')->nullable();

            // Location
            $table->string('plot_no')->nullable();
            $table->string('street')->nullable();
            $table->text('location')->nullable();
            $table->decimal('latitude', 12, 8)->nullable();
            $table->decimal('longitude', 12, 8)->nullable();

            // Size / Price
            $table->string('plot_size')->nullable(); // e.g. 5 Marla, 1 Kanal
            $table->string('plot_dimensions')->nullable();
            $table->integer('price')->nullable();
            $table->integer('rent')->nullable();
            $table->string('rent_type')->nullable(); // monthly, yearly etc.

            // Property dynamic features (handled via separate table)
            $table->json('features')->nullable(); // dynamic: bedrooms, kitchens, garages, etc.

            // Area-specific details
            $table->json('nearby_facilities')->nullable(); // hospitals, parks, schools, etc.
            $table->json('installment_plan')->nullable();

            // Flags
            $table->boolean('best_selling')->default(false);
            $table->boolean('today_deal')->default(false);
            $table->boolean('approved')->default(false);
            $table->string('status')->default('disabled');

            // Extra media / embeds
            $table->text('map_embed')->nullable();
            $table->text('video_embed')->nullable();
            $table->text('short_video_url')->nullable();
            $table->text('extra_data')->nullable(); // fallback for anything not mapped yet

            // System tracking
            $table->string('created_by')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
