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
    Schema::create('payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('order_id')->constrained()->cascadeOnDelete();
      $table->float('amount')->default(0);
      $table->char('payment_provider', 20)->nullable();
      $table->char('payment_method', 20)->nullable();
      $table->string('currency', 3)->default('USD');
      $table->enum('status', ['processing', 'succeeded', 'failed', 'canceled'])->default('processing');
      $table->string('transaction_id')->nullable();
      $table->json('transaction_details')->nullable();
      $table->timestamp('payment_date')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('payments');
  }
};
