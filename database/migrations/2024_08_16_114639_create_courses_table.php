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
            $table->foreignId('user_id')->constrained();
            $table->string('title', 50);
            $table->string('headline', 255);
            $table->text('description');
            $table->string('image', 255);
            $table->string('preview_video', 255);
            $table->foreignId('language_id')->constrained();
            $table->float('price', 8, 2);
            $table->json('learn');
            $table->text("requirements");
            $table->enum('status', ['active', 'inactive', 'removed', 'blocked'])->default('active');
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
