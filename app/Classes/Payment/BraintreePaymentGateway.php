<?php

namespace App\Classes\Payment;

use App\Interfaces\PaymentGatewayInterface;

class BraintreePaymentGateway implements PaymentGatewayInterface
{
  public function charge($amount, $currency, $description, $options = [])
  {
  }
}
