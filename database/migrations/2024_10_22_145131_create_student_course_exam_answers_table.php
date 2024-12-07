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
    Schema::create('student_course_exam_answers', function (Blueprint $table) {
      $table->id();
      $table->foreignUuid('std_course_exam_id')->constrained('student_course_exams', 'id')->cascadeOnDelete();
      $table->foreignId('question_id')->constrained('exam_questions', 'id')->cascadeOnDelete();
      $table->foreignId('answer_id')->constrained('exam_question_answers', 'id')->cascadeOnDelete();

      $table->text('content')->nullable();
      $table->boolean('is_true')->nullable();
      $table->text('info')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('student_course_exam_answers');
  }
};
