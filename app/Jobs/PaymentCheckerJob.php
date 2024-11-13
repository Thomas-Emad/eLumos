<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentCheckerJob implements ShouldQueue
{
  use Queueable;

  /**
   * Maximum number of times the job can be retried.
   *
   * @var int
   */
  public $tries = 2;

  /**
   * Number of seconds before the job is retried.
   *
   * @var int
   */
  public $retryAfter = 60;

  /**
   * Create a new job instance.
   */
  public function __construct(public $userId, public $orderId, public $transactionId, public string $status)
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    DB::transaction(function () {
      try {
        $user = User::findOrFail($this->userId);
        $order = Order::with('items')->where('id', $this->orderId)->firstOrFail();

        // Check if payment succeeded
        if ($this->status == 'succeeded') {
          $user->enrolledCourses()->attach($order->items->pluck('course_id')->toArray());
          $user->baskets()->delete();
        }

        // Update payment status and date
        $order->update([
          'status' => $this->status
        ]);
        Payment::where('order_id', $this->orderId)
          ->where('transaction_id', $this->transactionId)
          ->update([
            'payment_date' => now(),
            'status' => $this->status
          ]);
        Log::info("Payment status updated for transaction {$this->transactionId}");
      } catch (\Exception $e) {
        Log::error("Payment handling failed for transaction {$this->transactionId}: " . $e->getMessage());
        throw $e;
      }
    });
  }

  /**
   * This method will be called if the job fails after the retries are exhausted.
   */
  public function failed(\Throwable  $exception)
  {
    Log::error("PaymentCheckerJob failed for transaction {$this->transactionId} after multiple attempts. Error: " . $exception->getMessage());
  }
}
