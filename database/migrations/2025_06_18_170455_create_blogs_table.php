<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            // who created it
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            // content
            $table->string('title');
            $table->string('slug')
                ->unique();
            $table->string('heading');
            $table->text('detail');

            // SEO fields
            $table->text('meta_keywords')
                ->nullable();
            $table->text('meta_description')
                ->nullable();
            // default domain for multi-tenant
            $table->string('domain', 255)
                ->default('advice.pk');
            // Soft deletes + timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
