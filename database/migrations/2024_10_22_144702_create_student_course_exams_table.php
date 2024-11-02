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
    Schema::create('student_course_exams', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignId('lecture_id')->constrained('course_lectures')->cascadeOnDelete();
      $table->foreignUuid('exam_id')->constrained('exams')->cascadeOnDelete();
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
      $table->float('degree')->default(0);
      $table->float('total_degree')->default(0);
      $table->enum('status', ['processing', 'waiting', 'sucess', 'failed'])->default('processing');
      $table->timestamp('finished_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('student_course_exams');
  }
};
