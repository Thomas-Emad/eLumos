<?php

namespace App\Classes\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Interfaces\PaymentGatewayInterface;

class PaypalPaymentGateway implements PaymentGatewayInterface
{
  /**
   * Create a new class instance.
   */
  public function __construct(protected $client_id, protected $client_secret, protected $base_url, protected $header)
  {
    $this->client_id = config("services.payments.paypal.publishable_key");
    $this->client_secret = config("services.payments.paypal.secret_key");
    $this->base_url = config("services.payments.paypal.base_url");
    $this->header = [
      "Accept" => "application/json",
      'Content-Type' => "application/json",
      'Authorization' => "Basic " . base64_encode("$this->client_id:$this->client_secret"),
    ];
  }


  /**
   * Builds the PayPal payment request and redirects the user to the PayPal payment page.
   * 
   * @param Collection $orders The orders to be paid
   * @param int $amountUseWallet The amount used from the wallet
   * 
   * @return \Illuminate\Http\RedirectResponse
   */
  public function view($orders, $amountUseWallet = 0)
  {
    $data = $this->formatData($orders,  $amountUseWallet);
    $response = $this->buildRequest("POST", "/v2/checkout/orders", $data);

    //handel payment response data and return it
    $responseData = $response->getData(true);

    if ($responseData['success']) {
      session([
        'paypal_transaction_id' => $responseData['data']['id'],
        'paypal_metadata' => [
          'amountUseWallet' => $amountUseWallet,
          'courses_id' => $orders->pluck('id')->join(','),
          'user_id' => Auth::user()->id,
        ],
      ]);
      return redirect()->away($responseData['data']['links'][1]['href']);
    }
    return  dd($response->getData(true)); // print error
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
        'payment_provider' => 'paypal',
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
   * Processes a callback from PayPal for a payment intent.
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
      $metadata = session('paypal_metadata'); // Retrieve metadata from the session
      $response = $this->buildRequest('POST', "/v2/checkout/orders/$paymentId/capture");
      $payment = $response->getData(true);

      if (!$payment['success']) {
        throw new \Exception("Error processing callback for payment.");
      }

      return [
        'transaction_id' => $paymentId,
        'method' => array_keys($payment['data']['payment_source']),
        'currency' =>   $payment['data']['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
        'status' =>   $payment['data']['purchase_units'][0]['payments']['captures'][0]['status'],
        'transaction_details' => $payment['data'],
        'metadata' => $metadata ?? null
      ];
    } catch (\Exception  $e) {
      Log::error("Failed to retrieve payment intent for ID {$paymentId}: " . $e->getMessage());
      throw new \Exception("Error processing callback for payment.");
    }
  }


  /**
   * Build a request to the PayPal API.
   * 
   * This method takes a HTTP method, a URL, and optional data and sends a request to the PayPal API.
   * The response is then parsed and returned as a JSON response.
   * 
   * @param string $method The HTTP method to use.
   * @param string $url The URL to send the request to.
   * @param array $data Optional data to send with the request.
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  protected function buildRequest($method, $url, $data = null): \Illuminate\Http\JsonResponse
  {
    try {
      //type ? json || form_params
      $response = Http::withHeaders($this->header)
        ->send($method, $this->base_url . $url, [
          'json' => $data
        ]);

      return response()->json([
        'success' => $response->successful(),
        'status' => $response->status(),
        'data' => $response->json(),
      ], $response->status());
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'status' => 500,
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  /**
   * Formats the data for a PayPal payment.
   *
   * This method takes the orders and an optional amount to use from the wallet and
   * returns an array of data that can be used to make a PayPal payment.
   *
   * @param mixed $orders The orders to be paid.
   * @param int $amountUseWallet The amount to use from the wallet.
   *
   * @return array An array of data that can be used to make a PayPal payment.
   */
  public function formatData($orders, $amountUseWallet = 0): array
  {
    return [
      "intent" => "CAPTURE",
      "purchase_units" => [
        [
          "amount" => [
            "currency_code" => 'USD',
            "value" => $orders->sum('price') - $amountUseWallet
          ]
        ],
      ],
      "payment_source" => [
        "paypal" => [
          "experience_context" => [
            "return_url" => route('checkout.callback', ['gateway' => 'paypal']),
            "cancel_url" => route("checkout.fail"),
          ]
        ]
      ]
    ];
  }
}
