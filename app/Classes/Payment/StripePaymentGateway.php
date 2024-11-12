<?php

namespace App\Classes\Payment;

use Stripe\Token;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\PaymentGatewayInterface;

class StripePaymentGateway
{

  public function __construct(private $stripe = null)
  {
    $this->stripe = new \Stripe\StripeClient(config('services.payments.stripe.secret_key'));
  }

  /**
   * Shows the Stripe payment form to the user.
   *
   * @param mixed $orders The orders to be paid
   * @return \Illuminate\Contracts\View\View The view object
   */
  public function view($orders)
  {
    return view('pages.student.paymentGateways.stripe', ['orders' => $orders]);
  }

  /**
   * Creates a payment intent for the user's active courses in their basket.
   * 
   * @return \Illuminate\Http\JsonResponse A JSON response containing the client secret of the payment intent.
   */
  public function paymentIntent()
  {
    $courses = Auth::user()->basketWithCourses()->select('courses.id', 'courses.price')->where('status', 'active')->get('price');

    $paymentIntent = $this->stripe->paymentIntents->create([
      'amount' =>  $courses->sum('price') * 100,
      'currency' => 'usd',
      'automatic_payment_methods' => ['enabled' => true],
    ]);
    return response()->json([
      'clientSecret' => $paymentIntent->client_secret
    ]);
  }

  /**
   * Creates a new payment record in the database using the given details
   *
   * @param int $orderId The ID of the order being paid for
   * @param string $transactionId The ID of the transaction in stripe
   * @param int $amount The amount of the transaction in cents
   * @param string $paymentMethod The payment method used (e.g. card, sepa, etc.)
   * @param string $currency The currency of the transaction (e.g. usd, eur, etc.)
   * @param string $status The status of the transaction (e.g. succeeded, failed, etc.)
   * @param array $transactionDetails The details of the transaction as returned by stripe
   *
   * @throws \Exception If the record cannot be saved to the database
   */
  public function charge(int $orderId, string $transactionId, float $amount, string $paymentMethod, string $currency, string $status, $transactionDetails)
  {
    try {
      Payment::create([
        'user_id' => auth()->user()->id,
        'order_id' => $orderId,
        'amount' => $amount,
        'payment_provider' => 'stripe',
        'payment_method' => $paymentMethod,
        'currency' => $currency,
        'status' => $status,
        'transaction_id' => $transactionId,
        'transaction_details' => json_encode($transactionDetails)
      ]);
    } catch (\Exception  $e) {
      Log::error("Failed to create payment record: " . $e->getMessage());
      throw new \Exception("Failed to save payment. Please try again.");
    }
  }

  /**
   * Callback function to verify the status of a stripe payment intent.
   *
   * @param string $paymentIntentId the id of the payment intent
   * @return array a dictionary with the following keys:
   *  - transaction_id
   *  - method
   *  - currency
   *  - status
   *  - transaction_details
   * @throws \Exception if the payment intent can't be found
   */
  public function callback($paymentIntentId)
  {
    try {
      $payment = $this->stripe->paymentIntents->retrieve($paymentIntentId, []);

      return [
        'transaction_id' => $paymentIntentId,
        'method' => $payment->payment_method_types,
        'currency' =>  $payment->currency,
        'status' =>  $payment->status,
        'transaction_details' => $payment,
      ];
    } catch (\Exception  $e) {
      Log::error("Failed to retrieve payment intent for ID {$paymentIntentId}: " . $e->getMessage());
      throw new \Exception("Error processing callback for payment.");
    }
  }
}
