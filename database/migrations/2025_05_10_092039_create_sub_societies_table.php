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
        Schema::create('sub_societies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('society_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->nullable(); // Phase, Zone, Enclave, etc.
            $table->string('meta_keywords')->nullable();
            $table->string('meta_detail')->nullable();
            $table->text('detail')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade');
            $table->index('society_id');
            $table->index('slug');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_societies');
    }
};
