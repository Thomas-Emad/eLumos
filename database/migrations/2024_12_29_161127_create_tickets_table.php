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
    Schema::create('tickets', function (Blueprint $table) {
      $table->id();
      $table->string('request_id', 30)->index();
      $table->foreignId('user_id')->constrained('users')->onDelete('no action');
      $table->string('subject')->nullable();
      $table->text('description')->nullable();
      $table->json('attachments')->nullable();
      $table->enum('type', ['assistant', 'payment', 'technial_support', 'other'])->default('assistant');
      $table->enum('status', ['pending', 'wait_support', 'wait_user', 'solved', 'close_support', 'close_user'])->default('pending');
      $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
      $table->integer('rate')->nullable();
      $table->text('feedback')->nullable();
      $table->timestamp('completed_at')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tickets');
  }
};
