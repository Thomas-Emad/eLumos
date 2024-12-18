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
    Schema::create('courses_enrolleds', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignUuId('course_id')->constrained()->cascadeOnDelete();
      $table->integer('progress_lectures')->default(0);
      $table->enum('status', ['new', 'completed', 'incomplete'])->default('new');
      $table->char('certificate_id')->nullable();
      $table->timestamp('buyer_at')->default(now());
      $table->timestamp('completed_at')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('courses_enrolleds');
  }
};
