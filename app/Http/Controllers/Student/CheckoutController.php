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
   * Shows the payment form for the user based on the given gateway.
   *
   * If the total price of the order is 0, it will process the order as free
   * and redirect to the success page.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
   */
  public function viewPayment(Request $request)
  {
    $order = $this->orders();
    if ($order->sum('price') == 0) {
      PaymentProcessFreeOrderJob::dispatch(auth()->user()->id, $order);
      return redirect()->route('checkout.success');
    } else {
      $request->gateway = $request->gateway ?? 'stripe';
      $gateway = PaymentGatewayFactory::make($request->gateway);

      return $gateway->view($order);
    }
  }
}
