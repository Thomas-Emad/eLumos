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
  public function __construct(public $userId, public $orders)
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $user = User::findOrFail($this->userId);
    $courseIds = $this->orders->pluck('id')->toArray();

    DB::transaction(function () use ($courseIds, $user) {
      $order = $user->orders()->create([
        'amount' => $this->orders->sum('price'),
        'status' => 'succeeded',
        'discount' => 0,
      ]);

      foreach ($courseIds as $courseId) {
        $order->items()->create(['course_id' => $courseId]);
      }

      $user->enrolledCourses()->attach($courseIds);
      $user->baskets()->delete();

      // Send Message here if needed
    });
  }

  public function failed(\Throwable $exception)
  {
    Log::error("Failed To Process Free Order after multiple attempts. Error: " . $exception->getMessage());
  }
}
