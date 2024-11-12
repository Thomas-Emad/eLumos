<?php

namespace App\Classes\Payment;

use App\Interfaces\PaymentGatewayInterface;

class PaymobPaymentGateway implements PaymentGatewayInterface
{
  public function charge($amount, $currency, $description, $options = [])
  {
  }
}
