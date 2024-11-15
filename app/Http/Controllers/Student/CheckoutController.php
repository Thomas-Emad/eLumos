<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Factories\PaymentGatewayFactory;
use App\Jobs\PaymentProcessFreeOrderJob;
use Illuminate\Routing\Controllers\HasMiddleware;

class CheckoutController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return [
      'permission:buy-courses',
    ];
  }

  /**
   * Retrieves all active courses in the user's basket along with their prices.
   *
   * @return \Illuminate\Database\Eloquent\Collection
   */
  private function orders()
  {
    $courses = Auth::user()->basketWithCourses()->select('courses.id', 'courses.price')->where('status', 'active')->get('id', 'price');
    return $courses;
  }

  /**
   * Retrieves all active courses in the user's basket, checks if the wallet amount and the order conditions are valid, 
   * and then shows the payment form to the user. If the order amount after applying wallet is 0, process the free order.
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function viewPayment(Request $request)
  {
    $order = $this->orders();
    $totalOrderAmount = $order->sum('price');

    // Check if the wallet amount and the order conditions are valid
    $validationResult = $this->checkOrderAmount($totalOrderAmount, $request->amountUseWallet);
    if ($validationResult) {
      return $validationResult;
    }

    // If the order amount after applying wallet is 0, process the free order
    if (($totalOrderAmount - $request->amountUseWallet) == 0) {
      PaymentProcessFreeOrderJob::dispatch(auth()->user()->id, $order, $request->amountUseWallet);

      return redirect()->route('checkout.success');
    } else {
      $request->gateway = $request->gateway ?? 'stripe';
      $gateway = PaymentGatewayFactory::make($request->gateway);

      return $gateway->view($order, $request->amountUseWallet);
    }
  }

  /**
   * Checks if the order amount and the amount to use from the wallet is valid.
   *
   * If the validation fails, it redirects back with a notification.
   *
   * @param float $totalAmountOrder The total amount of the order
   * @param float $totalUseWallet The total amount to use from the wallet
   *
   * @return null|\Illuminate\Http\RedirectResponse
   */
  public function checkOrderAmount(float $totalAmountOrder, float $totalUseWallet): null|\Illuminate\Http\RedirectResponse
  {
    $userWallet = Auth::user()->wallet;
    if ($totalUseWallet > $userWallet || (($totalAmountOrder - $totalUseWallet) < 5 && ($totalAmountOrder - $totalUseWallet) > 0)) {
      return redirect()->back()->with('notification', [
        'type' => 'fail',
        'message' => 'The amount of the order must be greater than 5 and less than or equal to your wallet balance.',
      ]);
    }

    return null;
  }
}
