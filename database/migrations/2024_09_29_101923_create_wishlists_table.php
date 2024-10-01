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
    Schema::create('wishlists', function (Blueprint $table) {
      $table->id();
      $table->foreignId("user_id")->on('users')->cascadeOnDelete();
      $table->foreignUuid("course_id")->on('courses')->cascadeOnDelete();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('wishlists');
  }
};
