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
        Schema::create('sub_sectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('sub_society_id')->nullable()->after('society_id');
            $table->foreign('sub_society_id')->references('id')->on('sub_societies')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_detail')->nullable();
            $table->text('detail')->nullable();
            $table->string('block', 20)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_sectors');
    }
};
