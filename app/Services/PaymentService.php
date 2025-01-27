<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class PaymentService
{
  /**
   * Retrieves courses by IDs from database.
   *
   * @param string $courses A comma-separated string of course IDs.
   * @return Course A collection of courses with their IDs and prices.
   */
  private function getCourses(string $courses): Collection
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
  public function createOrder($userId, string $status, string $courses, float $amountUseWallet = 0): array
  {
    $user =  User::where('id', $userId)->first();
    $courses = $this->getCourses($courses);
    $order = $user->orders()->create([
      'amount' => $courses->sum('price'),
      'status' => $status,
      'amount_use_wallet' => $amountUseWallet,
      'discount' => 0,
    ]);

    foreach ($courses as $course) {
      $order->items()->create([
        'course_id' => $course->id,
        'amount' => $course->price,
        'user_profit' => $this->calcProfitInstructor($course->price, 0.1),
        'platform_profit' => $this->calcProfitPlatform($course->price, 0.1)
      ]);
    }

    $this->decrementWallet($userId, $amountUseWallet);

    return [
      'order_id' => $order->id,
      'courses' => $courses->pluck('id')->toArray(),
      'amount' => $order->amount - $amountUseWallet,
    ];
  }

  private function calcProfitInstructor($amount, $percentage)
  {
    return $amount - ($amount * $percentage);
  }

  private function calcProfitPlatform($amount, $percentage)
  {
    return $amount * $percentage;
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

  /**
   * Formats the payment status to a standard output.
   *
   * Converts the given status to lowercase and returns standardized versions
   * of the payment status. This method maps multiple possible input statuses
   * to a smaller set of standardized outputs: 'pending', 'succeeded', 'failed',
   * or 'canceled'.
   *
   * @param string $status The original payment status.
   * @return string The standardized payment status.
   */
  public function formatStatus($status): string
  {
    $status = strtolower($status);
    if ($status == 'pending') {
      return 'pending';
    } elseif (in_array($status, ['succeeded', 'completed'])) {
      return 'succeeded';
    } elseif (in_array($status, ['denied', 'failed'])) {
      return 'failed';
    } else {
      return 'canceled';
    }
  }

  /**
   * Retrieves the transaction ID from the request based on the payment gateway.
   *
   * @param \Illuminate\Http\Request $request The HTTP request containing payment gateway data.
   * @param string $gateway The payment gateway name ('stripe' or 'paypal').
   * @return string The transaction ID associated with the payment.
   */
  public function getTransactionId(Request $request, $gateway)
  {
    return match ($gateway) {
      'stripe' => $request->payment_intent,
      'paypal' => $request->token,
    };
  }
}
