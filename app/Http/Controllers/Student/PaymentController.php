<?php

namespace App\Http\Controllers\Student;

use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Factories\PaymentGatewayFactory;
use Illuminate\Routing\Controllers\HasMiddleware;

class PaymentController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return [
      'permission:buy-courses',
    ];
  }

  /**
   * Creates an order for the authenticated user with the given status.
   *
   * This function retrieves all active courses from the user's basket,
   * calculates the total amount, and creates an order with the specified status.
   * It then associates each course with the order as an order item.
   *
   * @param string $status The status of the order to be created.
   * @return array An array containing the order ID, list of course IDs, and total amount.
   */
  private function createOrder($status)
  {
    $courses = Auth::user()->basketWithCourses()->select('courses.id', 'courses.price')->where('status', 'active')->get('id', 'price');
    $order = Auth::user()->orders()->create([
      'amount' => $courses->sum('price'),
      'status' => $status,
      'discount' => 0,
    ]);

    foreach ($courses->pluck('id')->toArray() as $course) {
      $order->items()->create([
        'course_id' => $course
      ]);
    }

    return [
      'order_id' => $order->id,
      'courses' => $courses->pluck('id')->toArray(),
      'amount' => $order->amount,
    ];
  }

  /**
   * Process payment callback from Stripe.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */

  public function callback(Request $request)
  {
    try {
      DB::beginTransaction();
      $gateway = PaymentGatewayFactory::make('stripe');
      $callback = $gateway->callback($request->payment_intent);
      $order = $this->createOrder($callback['status']);

      // Add New Payment
      $gateway->charge(
        $order['order_id'],
        $callback['transaction_id'],
        $order['amount'],
        $callback['method'][0],
        $callback['currency'],
        $callback['status'],
        $callback['transaction_details'],
      );

      // Attach Courses
      if ($callback['status'] == 'succeeded') {
        Auth::user()->enrolledCourses()->attach($order['courses']);
        Auth::user()->baskets()->delete();

        Payment::where('order_id', $order['order_id'])
          ->where('transaction_id', $callback['transaction_id'])
          ->update(['payment_date' => now()]);

        DB::commit();
        return redirect()->route('checkout.success');
      }

      $message = $callback['status']  == 'failed' ?
        'Something is wrong, please try again?'
        : 'The process may take a little time. You should wait a little.';

      DB::commit();
      return redirect()->route('checkout.fail')->with('notification', [
        'type' => 'fail',
        'message' => $message
      ]);
    } catch (\Exception  $e) {
      DB::rollBack();
      Log::error("Failed to retrieve payment intent for ID {$request->payment_intent}: " . $e->getMessage());
      return redirect()->route('checkout.fail')->with('notification', [
        'type' => 'fail',
        'message' => "Something is wrong, please try again?"
      ]);
    }
  }

  /**
   * Display a success page to the user after a successful payment.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function success()
  {
    return view('pages.student.paymentGateways.success');
  }

  /**
   * Display a fail page to the user after a failed payment.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function fail()
  {
    return view('pages.student.paymentGateways.fail');
  }
}
