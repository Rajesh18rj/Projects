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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('tagline');
            $table->string('title');
            $table->text('description');
            $table->json('learnings');    #--> we use json method for storing array data type in database
            $table->timestamp('released_at')->nullable();
            $table->string('image_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * jaksjh
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
