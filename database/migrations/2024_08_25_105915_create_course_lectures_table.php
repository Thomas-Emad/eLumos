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
    Schema::create('course_lectures', function (Blueprint $table) {
      $table->id();
      $table->foreignUuid('course_id')->constrained()->onDelete('cascade');
      $table->unsignedBigInteger('section_id');
      $table->foreign('section_id')->references('id')->on('course_sections')->onDelete('cascade');

      $table->json('video')->nullable();
      $table->decimal('video_duration', 5, 2)->nullable();
      $table->text('content')->nullable();

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
    Schema::dropIfExists('course_lectures');
  }
};
