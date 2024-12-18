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
    Schema::create('exam_questions', function (Blueprint $table) {
      $table->id();
      $table->foreignUuid('exam_id')->constrained('exams')->cascadeOnDelete();
      $table->string('title', 255);
      $table->enum('type_question', ['text', 'radio', 'checkbox', 'attachment']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('exam_questions');
  }
};
