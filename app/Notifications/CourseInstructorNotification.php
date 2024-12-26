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
    return ['database', 'mail'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): MailMessage
  {
    $content = $this->messageMailByStatus($this->course->status);
    return (new MailMessage)
      ->greeting($content['head'])
      ->line($content['line'])
      ->action($content['action']['message'], $content['action']['route'])
      ->line($content['last_line']);
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

  /**
   * messageByStatus function
   *
   * This Function use for print mesasge database By Status Course
   * 
   * @param string $status
   * @return string
   */
  private function messageByStatus(string $status): string
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

  /**
   * messageMailByStatus function
   * 
   * This function use for get message Mail By Status Course
   * if there's no status's array give it defult value
   *
   * @param string $status
   * @return array
   */
  private function messageMailByStatus(string $status): array
  {
    $content = [
      "draft" => [
        'head' => "Hello! We Got it",
        "line" => "The course has been created successfully. We recommend that you review how to present distinctive content, because organization and planning is an essential element in any distinctive content. Of course, you can look at our best-selling courses on the platform so that you can know how they succeeded and distinguished themselves. We wish you success.",
        "action" => [
          'message' => "Continue Edit Course",
          'route' => route("dashboard.instructor.courses.edit", $this->course->id)
        ],
        "last_line" => "Thank you for using our platform and we wish you success."
      ],
      "pending" => [
        'head' => "Your Course is Under Review",
        "line" => "Your course has been successfully submitted, and our experts are now reviewing it to ensure it meets our platform’s guidelines. This process typically takes a little time, but we’ll notify you once it’s approved.",
        "action" => [
          'message' => "Track Course Status",
          'route' => route("dashboard.instructor.courses.status", $this->course->id)
        ],
        "last_line" => "Thank you for your patience, and we look forward to seeing your course on our platform soon."
      ],
      "rejected" => [
        'head' => "Your Course Was Rejected",
        "line" => "Unfortunately, your course was not approved. Please review the feedback from our team, address any issues, and resubmit your course. We're here to help if you have any questions.",
        "action" => [
          'message' => "Review Feedback",
          'route' => route("dashboard.instructor.courses.status", $this->course->id)
        ],
        "last_line" => "Don't give up! We believe your course has potential, and we’re here to assist you in getting it ready for approval."
      ],
      "active" => [
        'head' => "Your Course is Live!",
        "line" => "Congratulations! Your course is now live on the platform. It’s time to start promoting it and attracting students.",
        "action" => [
          'message' => "Manage Course",
          'route' => route("dashboard.instructor.courses.tracking", $this->course->id)
        ],
        "last_line" => "Good luck with your course! We're excited to see it succeed."
      ],
      "inactive" => [
        'head' => "Course Suspended",
        "line" => "Unfortunately, your course has been suspended from the platform. Please review the suspension notice to understand the reason behind it. You may contact support for more details and to appeal the suspension.",
        "action" => [
          'message' => "Manage Course",
          'route' => route("dashboard.instructor.courses.status", $this->course->id)
        ],
        "last_line" => "We hope to resolve this issue as soon as possible so your course can go live again."
      ],
      "removed" => [
        'head' => "Course Removed",
        "line" => "Your course has been permanently removed from our platform. If you believe this was a mistake, please reach out to our support team for clarification or to appeal the removal.",
        "action" => [
          'message' => "Contact Support",
          'route' => route("dashboard.instructor.support")
        ],
        "last_line" => "Thank you for your contributions to the platform, and we hope to work with you again in the future."
      ],
      "blocked" => [
        'head' => "Course Blocked",
        "line" => "Your course has been blocked from the platform for violation of our terms. Please review the reasons outlined in the notification and contact support for further assistance.",
        "action" => [
          'message' => "Appeal Decision",
          'route' => route("dashboard.instructor.courses.status", $this->course->id)
        ],
        "last_line" => "We are committed to resolving issues fairly and will assist you through the process."
      ]
    ];

    return $content[$status] ?? [
      'head' => "Unknown Status",
      'line' => "It seems there was an issue processing your course status. Please contact support for assistance.",
      'action' => [
        'message' => "Contact Support",
        'route' => route("dashboard.instructor.support")
      ],
      'last_line' => "We apologize for the inconvenience and are here to help."
    ];
  }
}
