<?php

use App\Enums\StatusTicketEnum;
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
    Schema::create('ticket_logs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
      $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();

      $table->enum('status', ['pending', 'wait_support', 'wait_user', 'solved', 'close_support', 'close_user'])->default('pending');
      $table->enum('priority', ['low', 'medium', 'high'])->default('medium');

      $table->text('reason')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ticket_logs');
  }
};
