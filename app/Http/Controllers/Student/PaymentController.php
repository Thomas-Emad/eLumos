<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
   * Process payment callback from Stripe.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function callback(Request $request, string $gateway = 'stripe')
  {
    try {
      DB::beginTransaction();
      $gateway = PaymentGatewayFactory::make($gateway);
      $callback = $gateway->callback($request->payment_intent);
      $order = (new PaymentService)->createOrder(
        $callback['metadata']['user_id'],
        $callback['status'],
        (int) $callback['metadata']['amountUseWallet'],
        $callback['metadata']['courses_id']
      );

      // Add New Payment
      $gateway->charge(
        $callback['metadata']['user_id'],
        $order['order_id'],
        $callback['transaction_id'],
        $order['amount'],
        $callback['method'][0],
        $callback['currency'],
        $callback['status'],
        $callback['transaction_details'],
      );
      DB::commit();

      if ($callback['status'] == 'succeeded') {
        return redirect()->route('checkout.success');
      }

      $message = $callback['status'] == 'failed' ?
        'Something is wrong, please try again?'
        : 'The process may take a little time. You should wait a little.';

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
