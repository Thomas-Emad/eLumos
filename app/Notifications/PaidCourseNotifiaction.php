<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaidCourseNotifiaction extends Notification  implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   */
  public function __construct(public $payment)
  {
    //
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['database', 'mail'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): MailMessage
  {
    $status = $this->payment->status;

    // Use the 3D array to get the message data for the corresponding status
    $messageData = $this->messagesMailByStatus($status);
    return (new MailMessage)
      ->subject($messageData['subject'])
      ->line($messageData['intro'])
      ->action($messageData['actionText'], ($messageData['actionUrl']))
      ->line($messageData['footer']);
  }


  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    // return [
    //   'sender' => "system",
    //   'payment_id' => $this->payment->id,
    //   'message' => $this->messageByStatus($this->payment->status)
    // ];

    return [
      'sender' => "system",
      'type' => 'payment',
      'id' => $this->payment->id,
      // 'title' => $this->payment->title,
      'status' => $this->payment->status,
      'message' => $this->messageByStatus($this->payment->status)
    ];
  }

  /**
   * messageByStatus function
   * it Use For display message in every case payment status
   *
   * @param string $status
   * @return string
   */
  private function messageByStatus(string $status): string
  {
    return match ($status) {
      'pending' => "Your purchase is currently being processed. You will be notified once it's confirmed.",
      'succeeded' => "Congratulations! Your purchase was successful. You can now start learning with your new course.",
      'failed' => "Unfortunately, your purchase could not be completed. Please try again or contact support if the issue persists.",
      'canceled' => "Your purchase has been canceled. If you believe this is an error, please reach out to customer support.",
      default => "An unknown status has occurred. Please contact support for assistance."
    };
  }


  /**
   * messagesMailByStatus function
   * 
   * This function returns an array of email content based on the given payment status.
   * The content includes the subject, introduction, action text, action URL, and footer text 
   * for the email notification. It handles different payment statuses such as pending, succeeded, 
   * failed, canceled, and provides a default message if the status is unrecognized.
   *
   * @param string $status The payment status. Accepted values are 'pending', 'succeeded', 
   *                       'failed', 'canceled', or 'default'.
   * @return array The email content for the specified status, including 'subject', 'intro', 
   *               'actionText', 'actionUrl', and 'footer'.
   */
  private function messagesMailByStatus(string $status): array
  {
    $content = [
      'pending' => [
        'subject' => 'Your Purchase is Being Processed',
        'intro' => 'Thank you for your purchase! Your order is currently being processed.',
        'actionText' => 'Check Order Status',
        'actionUrl' => route("dashboard.orders.index", $this->payment->id),
        'footer' => 'Thank you for your patience!',
      ],
      'succeeded' => [
        'subject' => 'Your Purchase Was Successful!',
        'intro' => 'Congratulations! Your purchase was successful.',
        'actionText' => 'Start Learning',
        'actionUrl' => route("dashboard.orders.index", $this->payment->id),
        'footer' => 'Enjoy your learning experience!',
      ],
      'failed' => [
        'subject' => 'Something Went Wrong With Your Purchase',
        'intro' => 'Oops, something went wrong with your purchase.',
        'actionText' => 'Retry Purchase',
        'actionUrl' => route("dashboard.orders.index", $this->payment->id),
        'footer' => 'Thank you for your understanding!',
      ],
      'canceled' => [
        'subject' => 'Your Purchase Has Been Canceled',
        'intro' => 'Your purchase has been canceled.',
        'actionText' => 'Contact Support',
        'actionUrl' => route("dashboard.orders.index", $this->payment->id),
        'footer' => 'We’re here to help!',
      ],
      'default' => [
        'subject' => 'Thank You for Using Our Platform',
        'intro' => 'We’ve received your request. If you need further assistance, don’t hesitate to contact our support team.',
        'actionText' => 'Contact Support',
        'actionUrl' => route("dashboard.orders.index", $this->payment->id),
        'footer' => 'Thank you for being a valued member of our community!',
      ]
    ];

    return $content[$status] ?? ['default'];
  }
}
