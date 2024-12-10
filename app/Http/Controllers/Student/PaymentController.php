<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Http\Resources\InvoicePaymentResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Factories\PaymentGatewayFactory;
use Illuminate\Routing\Controllers\HasMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return [
      'permission:buy-courses',
    ];
  }

  /**
   * index function
   *
   * @return View
   */
  public function index(): View
  {
    $payments = Payment::withCount('items')->latest()->paginate(20);
    return view('pages.dashboard.student.payments.index', compact('payments'));
  }

  /**
   * show function
   *
   * @param string $id
   * @return View
   */
  public function show(string $id)
  {
    // if (!request()->ajax()) {
    //   return abort(404);
    // }

    $paymentContent = Payment::with([
      'order',
      'order.items',
      'order.items.course',
    ])->where('transaction_id', $id)->firstOrFail();
    $payment = (object) (new InvoicePaymentResource($paymentContent))->toArray(request());

    // return $payment->order['items'][0];
    $html = view('pages.dashboard.student.payments.partials.show-payment', compact('payment'))->render();

    return response()->json(['html' => $html]);
  }

  /**
   * Process payment callback from Stripe.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function callback(Request $request, string $gateway = 'stripe'): \Illuminate\Http\RedirectResponse
  {
    try {
      DB::beginTransaction();

      // init Platform
      $servicePayment =  new PaymentService;
      $paymentId = $servicePayment->getTransactionId($request, $gateway);
      $gateway = PaymentGatewayFactory::make($gateway);
      $callback = $gateway->callback($paymentId);
      $status = $servicePayment->formatStatus($callback['status']);

      // Insert New Recored in DB for This Order
      $order = (new PaymentService)->createOrder(
        $callback['metadata']['user_id'],
        $status,
        $callback['metadata']['courses_id'],
        (int) $callback['metadata']['amountUseWallet']
      );

      // Add New Payment
      $gateway->charge(
        $callback['metadata']['user_id'],
        $order['order_id'],
        $callback['transaction_id'],
        $order['amount'],
        $callback['method'][0],
        $callback['currency'],
        $status,
        $callback['transaction_details'],
      );
      DB::commit();

      return $this->returnRedirect($callback['status']);
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
   * Redirects the user based on the payment status.
   *
   * Depending on the provided status, this function redirects the user to the appropriate route.
   * - If the status is 'succeeded', the user is redirected to the success page.
   * - If the status is 'failed', the user is redirected to the fail page with a failure notification.
   * - If the status is 'pending', the user is redirected to the pending page with a pending notification.
   *
   * @param string $status The status of the payment process (e.g., succeeded, failed, pending).
   * @return \Illuminate\Http\RedirectResponse The redirect response to the appropriate page.
   */
  private function returnRedirect(string $status): \Illuminate\Http\RedirectResponse
  {
    switch ($status) {
      case 'succeeded':
        return redirect()->route('checkout.success');
        break;

      case 'pending':
        return redirect()->route('checkout.pending')->with('notification', [
          'type' => 'fail',
          'message' => "The process may take a little time. You should wait a little."
        ]);
        break;

      case 'failed':
        return redirect()->route('checkout.fail')->with('notification', [
          'type' => 'fail',
          'message' => "Something is wrong, please try again?"
        ]);
        break;

      default:
        return redirect()->route('checkout.canceled')->with('notification', [
          'type' => 'fail',
          'message' => "Something is wrong, please try again?"
        ]);
        break;
    }
  }

  /**
   * Display a success page to the user after a successful payment.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function success(): View
  {
    return view('pages.student.paymentGateways.success');
  }

  /**
   * Display a fail page to the user after a failed payment.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function fail(): View
  {
    return view('pages.student.paymentGateways.fail');
  }

  /**
   * Display a pending page to the user after a pending payment.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function pending(): View
  {
    return view('pages.student.paymentGateways.pending');
  }

  /**
   * Display a canceled page to the user after a cancele payment.
   *
   * @return \Illuminate\Contracts\View\View
   */
  public function canceled(): View
  {
    return view('pages.student.paymentGateways.canceled');
  }
}
