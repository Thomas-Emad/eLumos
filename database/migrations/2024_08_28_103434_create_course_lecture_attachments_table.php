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
    Schema::create('course_lecture_attachments', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('lecture_id');
      $table->string('title', 50);
      $table->string('attachment');
      $table->timestamps();

      $table->foreign('lecture_id')->references('id')->on('course_lectures')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('course_lecture_attachments');
  }
};
