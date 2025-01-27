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
    Schema::create('course_sections', function (Blueprint $table) {
      $table->id();
      $table->foreignUuid('course_id')->constrained()->onDelete('cascade');
      $table->string('title', 50);
      $table->integer('order_sort')->default(1);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('course_sections');
  }
};
