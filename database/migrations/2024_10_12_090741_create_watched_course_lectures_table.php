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
    Schema::create('watched_course_lectures', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignUuid("course_id")->constrained()->cascadeOnDelete();
      $table->unsignedBigInteger('lecture_id');
      $table->timestamps();

      $table->foreign('lecture_id')->references('id')->on('course_lectures')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('watched_course_lectures');
  }
};
