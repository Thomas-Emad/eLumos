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
  public function syncPaymentNotFound($paymentId, string $gateway): Payment
  {
    DB::beginTransaction();
    $gateway = PaymentGatewayFactory::make($gateway);
    $callback = $gateway->callback($paymentId);
    $order = (new PaymentService)->createOrder(
      $callback['metadata']['user_id'],
      $callback['status'],
      $callback['metadata']['courses_id'],
      (int) $callback['metadata']['amountUseWallet']
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
        (new PaymentService)->formatStatus(explode('.', $event->type)[1])
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

  /**
   * Handle incoming PayPal webhook events.
   *
   * @param Request $request The incoming HTTP request containing the PayPal webhook event data.
   *
   * @return \Illuminate\Http\Response A response indicating the result of handling the webhook.
   *
   * This function processes PayPal webhook events by verifying the payment ID from the request's
   * resource data and checking if the payment record exists in the database. If the payment 
   * does not exist, it attempts to sync the payment. It then dispatches a job to update the order 
   * status and add courses. In case of an exception, it returns an appropriate error response.
   */
  public function handlePaypalWebhook(Request $request)
  {
    try {
      $paymentId = $request->resource['supplementary_data']['related_ids']['order_id'];
      $payment =  Payment::where('transaction_id', $paymentId)->first();
      if (!$payment) {
        $payment = $this->syncPaymentNotFound($paymentId, 'paypal');
      }

      // Send Job for add courses and update order status
      PaymentCheckerJob::dispatch(
        $payment->user_id,
        $payment->order_id,
        $paymentId,
        (new PaymentService)->formatStatus($request->resource['status'])
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
