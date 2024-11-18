<?php

namespace App\Classes\Payment;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\PaymentGatewayInterface;

class StripePaymentGateway implements PaymentGatewayInterface
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
  public function view($orders, $amountUseWallet = 0)
  {
    return view('pages.student.paymentGateways.stripe', ['orders' => $orders, 'amountUseWallet' => $amountUseWallet]);
  }

  /**
   * Creates a payment intent for the user's active courses in their basket.
   * 
   * @return \Illuminate\Http\JsonResponse A JSON response containing the client secret of the payment intent.
   */
  public function paymentIntent(Request $request)
  {
    $courses = Auth::user()->basketWithCourses()->select('courses.id', 'courses.price')->where('status', 'active')->get('id', 'price');

    $paymentIntent = $this->stripe->paymentIntents->create([
      'amount' => ($courses->sum('price') - $request->amountUseWallet) * 100,
      'currency' => 'usd',
      'automatic_payment_methods' => ['enabled' => true],
      'metadata' => [
        'amountUseWallet' => $request->amountUseWallet,
        'courses_id' => $courses->pluck('id')->join(','),
        'user_id' => $request->user()->id,
      ],
    ]);
    return response()->json([
      'clientSecret' => $paymentIntent->client_secret
    ]);
  }


  /**
   * Records a payment transaction in the database.
   *
   * This method creates a new payment record in the database for the specified order and user.
   * It saves details such as the amount, payment method, currency, and status.
   *
   * @param int $userId The ID of the user making the payment.
   * @param int $orderId The ID of the order associated with the payment.
   * @param string $transactionId The unique ID of the transaction.
   * @param float $amount The amount of the payment.
   * @param string $paymentMethod The method used for the payment (e.g., card, bank transfer).
   * @param string $currency The currency of the payment (e.g., USD, EUR).
   * @param string $status The status of the payment (e.g., succeeded, failed).
   * @param mixed $transactionDetails Additional details about the transaction.
   *
   * @throws \Exception If the payment record cannot be saved.
   * @return \App\Models\Payment The created payment record.
   */
  public function charge($userId, int $orderId, string $transactionId, float $amount, string $paymentMethod, string $currency, string $status, $transactionDetails)
  {
    try {
      return Payment::create([
        'user_id' => $userId,
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
   * Processes a callback from Stripe for a payment intent.
   *
   * This method is called from the webhook endpoint and will be triggered when a payment
   * is completed but the payment was not found in the database. This is normally
   * caused by a race condition where the payment was completed before the
   * payment intent was created. This method will create the payment intent and
   * then call the charge method to create the payment record in the database.
   *
   * @param string $paymentId The ID of the payment intent.
   *
   * @return array An array of information about the payment.
   *
   * @throws \Exception If the payment intent cannot be retrieved.
   */
  public function callback(string $paymentId)
  {
    try {
      $payment = $this->stripe->paymentIntents->retrieve($paymentId, []);

      return [
        'transaction_id' => $paymentId,
        'method' => $payment->payment_method_types,
        'currency' =>  $payment->currency,
        'status' =>  $payment->status,
        'transaction_details' => $payment,
        'metadata' => $payment->metadata ?? null
      ];
    } catch (\Exception  $e) {
      Log::error("Failed to retrieve payment intent for ID {$paymentId}: " . $e->getMessage());
      throw new \Exception("Error processing callback for payment.");
    }
  }
}
