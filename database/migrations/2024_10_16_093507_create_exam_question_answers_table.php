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
    Schema::create('exam_question_answers', function (Blueprint $table) {
      $table->id();
      $table->foreignUuid('exam_id')->constrained('exams')->cascadeOnDelete();
      $table->foreignId('question_id')->constrained('exam_questions')->cascadeOnDelete();
      $table->enum('type_question', ['text', 'radio', 'checkbox', 'attachment']);
      $table->text('answer')->nullable();
      $table->boolean('is_true')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('exam_question_answers');
  }
};
