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
    Schema::create('exam_course_lectures', function (Blueprint $table) {
      $table->id();
      $table->foreignUuid('exam_id')->constrained('exams')->cascadeOnDelete();
      $table->foreignUuid('course_id')->constrained('courses')->cascadeOnDelete();
      $table->foreignId('lecture_id')->constrained('course_lectures')->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('exam_course_lectures');
  }
};
