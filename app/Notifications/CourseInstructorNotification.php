<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseInstructorNotification extends Notification implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   */
  public function __construct(public $course)
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
    return ['database'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): MailMessage
  {
    return (new MailMessage)
      ->line('The introduction to the notification.')
      ->action('Notification Action', url('/'))
      ->line('Thank you for using our application!');
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toDatabase(object $notifiable): array
  {
    return [
      'sender' => "system",
      'course_id' => $this->course->id,
      'title' => $this->course->title,
      'status' => $this->course->status,
      'message' => $this->messageByStatus($this->course->status)
    ];
  }

  private function messageByStatus($status)
  {
    return match ($status) {
      'draft' => 'The course is waiting for you to finish preparing it so you can publish it.',
      'pending' => 'The course has been sent successfully, but it must be checked carefully by experts first.',
      'redject' => 'Sorry, for some reason your course was rejected, please check and fix the errors and try again.',
      'active' => 'Your course has been successfully accepted, you can now work on its advertisements',
      'inactive' => 'Your course has been suspended from the platform.',
      'removed' => 'Your course has been permanently deleted from our platform.',
      'blocked' => 'This course has been banned from the platform for some reason. If you see this as an error, you can contact technical support to find out more.',
    };
  }
}
