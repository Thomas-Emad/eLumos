<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
  public function charge($amount, $currency, $description, $options = []);
}
