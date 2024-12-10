<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class InvoicePaymentResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $currency = Str::upper($this->currency);
    return [
      'title' => getMessagePaymentByStatus($this->status),
      'photo' => getImagePaymentByStatus($this->status),
      'transaction_id' => $this->transaction_id,
      'amount_paid' => $this->amount . " " .  $currency,
      'payment_provider' => $this->payment_provider,
      'payment_method' => $this->payment_method,
      'status' => $this->status,
      'payment_date' => $this->payment_date,
      'created_at' => $this->created_at,
      'order' => [
        'total_amount_order' => $this->order->amount . " " .  $currency,
        'discount' => $this->order->discount . " " .  $currency,
        'amount_use_wallet' => $this->order->amount_use_wallet . " " .  $currency,
        'items' => (OrderItemsResource::collection($this->order->items)
          ->additional(['currency' => $currency])
        )->toArray(request())
      ]
    ];
  }
}
