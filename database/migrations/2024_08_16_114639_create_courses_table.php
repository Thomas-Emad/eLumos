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
      $table->uuid('id')->primary();
      $table->foreignId('user_id')->constrained();
      $table->string('title', 50)->nullable();
      $table->string('headline', 255)->nullable();
      $table->text('description')->nullable();
      $table->string('image', 255)->nullable();
      $table->string('preview_video', 255)->nullable();
      $table->foreignId('language_id')->nullable()->constrained();
      $table->float('price', 8, 2)->nullable();
      $table->text('learn')->nullable();
      $table->text("requirements")->nullable();
      $table->integer("steps")->default(2);
      $table->enum('status', ['draft', 'pending', 'active', 'inactive', 'removed', 'blocked'])->default('draft');
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
