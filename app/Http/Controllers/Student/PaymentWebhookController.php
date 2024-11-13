<?php

namespace App\Http\Controllers\Student;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\PaymentCheckerJob;
use App\Http\Controllers\Controller;

class PaymentWebhookController extends Controller
{
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
      $payment =  Payment::where('transaction_id', $paymentId)->firstOrFail();
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
