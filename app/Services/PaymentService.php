<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;

class PaymentService
{
  /**
   * Retrieves courses by IDs from database.
   *
   * @param string $courses A comma-separated string of course IDs.
   * @return Course A collection of courses with their IDs and prices.
   */
  private function getCourses(string $courses): Course
  {
    $coursesId = explode(',',  $courses);
    return Course::whereIn('id', $coursesId)->select('id', 'price')->get('id', 'price');
  }

  /**
   * Creates an order for the given user with specified courses and updates the user's wallet.
   *
   * This method retrieves the user and their selected courses, creates an order with those courses, 
   * and deducts the specified amount from the user's wallet. It then returns the order details.
   *
   * @param int $userId The ID of the user creating the order.
   * @param string $status The status of the order.
   * @param float $amountUseWallet The amount to use from the user's wallet. Default is 0.
   * @param string $courses A comma-separated string of course IDs.
   * @return array An array containing the order ID, course IDs, and the total amount after wallet usage.
   */
  public function createOrder($userId, string $status, float $amountUseWallet = 0, string $courses): array
  {
    $user =  User::where('id', $userId)->first();
    $courses = $this->getCourses($courses);
    $order = $user->orders()->create([
      'amount' => $courses->sum('price'),
      'status' => $status,
      'discount' => 0,
    ]);

    foreach ($courses as $course) {
      $order->items()->create([
        'course_id' => $course->id,
        'amount' => $course->price
      ]);
    }

    $this->decrementWallet($userId, $amountUseWallet);

    return [
      'order_id' => $order->id,
      'courses' => $courses->pluck('id')->toArray(),
      'amount' => $order->amount - $amountUseWallet,
    ];
  }

  /**
   * Decrements the user's wallet by the given amount if the amount is greater than 0.
   *
   * @param int $userId The ID of the user.
   * @param float $amountUseWallet The amount to decrement the wallet by.
   * @return void
   */
  private function decrementWallet($userId, float $amountUseWallet = 0): void
  {
    if ($amountUseWallet != 0) {
      User::where('id', $userId)->decrement('wallet', $amountUseWallet);
    }
  }
}
