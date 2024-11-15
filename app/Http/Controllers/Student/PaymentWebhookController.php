<?php

namespace App\Http\Controllers\Student;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\PaymentCheckerJob;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Factories\PaymentGatewayFactory;

class PaymentWebhookController extends Controller
{


  /**
   * Sync a payment that was not found in the database.
   *
   * This is called from the webhook endpoint and will be triggered when a payment
   * is completed but the payment was not found in the database. This is normally
   * caused by a race condition where the payment was completed before the
   * payment intent was created. This method will create the payment intent and
   * then call the charge method to create the payment record in the database.
   *
   * @param string $gateway The name of the payment gateway.
   * @param string $paymentId The ID of the payment.
   *
   * @return \App\Models\Payment The new payment record.
   */
  public function syncPaymentNotFound(string $gateway, string $paymentId): Payment
  {
    DB::beginTransaction();
    $gateway = PaymentGatewayFactory::make($gateway);
    $callback = $gateway->callback($paymentId);
    $order = (new PaymentService)->createOrder(
      $callback['metadata']['user_id'],
      $callback['status'],
      (int) $callback['metadata']['amountUseWallet'],
      $callback['metadata']['courses_id']
    );

    // Add New Payment
    return $gateway->charge(
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
  }

  /**
   * Handle incoming Stripe webhook events.
   *
   * @param Request $request
   *
   * @return Response
   */
  public function handleStripeWebhook(Request $request)
  {
    $endpoint_secret = config('services.payments.stripe.webhook_secret');
    $payload = $request->getContent();
    $signatureHeader = $request->header('Stripe-Signature');

    try {
      $event = \Stripe\Webhook::constructEvent(
        $payload,
        $signatureHeader,
        $endpoint_secret
      );

      $paymentId = $event->data['object']['payment_intent'];
      $payment =  Payment::where('transaction_id', $paymentId)->first();
      if (!$payment) {
        $payment = $this->syncPaymentNotFound('stripe', $paymentId);
      }

      // Send Job for add courses and update order status
      PaymentCheckerJob::dispatch(
        $payment->user_id,
        $payment->order_id,
        $paymentId,
        explode('.', $event->type)[1]
      );

      // Send Message To CLient Tell him what's happen now
      // It's will be event to mail, noitication server
      return response('Webhook handled', Response::HTTP_OK);
    } catch (\UnexpectedValueException $e) {
      return response('Invalid payload', Response::HTTP_BAD_REQUEST);
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
      return response('Invalid signature', Response::HTTP_BAD_REQUEST);
    }
  }
}
