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
    Schema::create('course_review_logs', function (Blueprint $table) {
      $table->id();
      $table->foreignUuid("course_id")->constrained()->cascadeOnDelete();
      $table->foreignId("reviewed_by")->constrained('users', 'id')->noActionOnDelete();
      $table->timestamp("reviewed_at");
      $table->text("reason")->nullable();
      $table->enum('status', ['draft', 'pending', 'rejected', 'active', 'inactive', 'removed', 'blocked'])->default('pending');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('course_review_logs');
  }
};
