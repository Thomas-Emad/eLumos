<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
  public function view($orders, $amountUseWallet = 0);
  public function charge($userId, int $orderId, string $transactionId, float $amount, string $paymentMethod, string $currency, string $status, $transactionDetails);
  public function callback(string $paymentId);
}
