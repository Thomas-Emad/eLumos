<?php

namespace App\Factories;

use App\Classes\Payment\StripePaymentGateway;
use App\Classes\Payment\PaypalPaymentGateway;
use App\Classes\Payment\PaymobPaymentGateway;

class PaymentGatewayFactory
{
  public static function make(string $paymentType): object
  {
    return match ($paymentType) {
      'stripe' => new StripePaymentGateway(),
      'paypal' => new PaypalPaymentGateway(),
      'paymob' => new PaymobPaymentGateway(),
      default => throw new \Exception('Invalid payment gateway'),
    };
  }
}
