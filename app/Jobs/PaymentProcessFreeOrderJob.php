<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentProcessFreeOrderJob implements ShouldQueue
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
  public function __construct(public $userId, public $orders, public float $amountUseWallet = 0)
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $user = User::findOrFail($this->userId);
    $orders = $this->orders;

    DB::transaction(function () use ($orders, $user) {
      $order = $user->orders()->create([
        'amount' => $orders->sum('price'),
        'status' => 'succeeded',
        'discount' => 0,
      ]);

      foreach ($orders as $course) {
        $order->items()->create([
          'course_id' => $course->id,
          'amount' => $course->price,
        ]);
      }

      $user->enrolledCourses()->attach($orders->pluck('id')->toArray());
      $user->baskets()->delete();

      // Update wallet here
      if ($this->amountUseWallet > 0) {
        $user->decrement('wallet', $this->amountUseWallet);
      }

      // Send Message here if needed
    });
  }

  public function failed(\Throwable $exception)
  {
    Log::error("Failed To Process Free Order after multiple attempts. Error: " . $exception->getMessage());
  }
}
