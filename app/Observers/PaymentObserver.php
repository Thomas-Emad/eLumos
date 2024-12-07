<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\User;
use App\Notifications\PaidCourseNotifiaction;
use Illuminate\Support\Facades\Notification;


class PaymentObserver
{
  /**
   * Handle the Payment "created" event.
   */
  public function created(Payment $payment): void
  {
    Notification::send(User::find($payment->user_id), new PaidCourseNotifiaction($payment));
  }

  /**
   * Handle the Payment "updated" event.
   */
  public function updated(Payment $payment): void
  {

    // send notifications:
    if ($payment->status != 'pending') {
      Notification::send(User::find($payment->user_id), new PaidCourseNotifiaction($payment));
    }
  }
}
