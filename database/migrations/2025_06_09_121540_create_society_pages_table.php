<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Create the society_pages table with full SEO and ownership support.
     */
    public function up(): void
    {
        Schema::create('society_pages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->comment('User who created this page');

            $table->string('slug')->unique()->comment('SEO slug like nova-city-islamabad');
            $table->string('title');
            $table->string('heading');
            $table->text('detail'); // HTML from Quill
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('domain', 100)
                ->default('advice.pk')
                ->index()
                ->comment('Domain the page belongs to, e.g., advice.pk');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Drop the society_pages table.
     */
    public function down(): void
    {
        Schema::dropIfExists('society_pages');
    }
};
