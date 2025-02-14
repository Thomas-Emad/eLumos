<?php

namespace App\Listeners;

use App\Events\ReminderUserForContinueCoursesEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Mail\SendMailReminderUserForContinueCoursesNotification;

class SendMailReminderUserForContinueCourses
{
    /**
     * Handle the event.
     */
    public function handle(ReminderUserForContinueCoursesEvent $event): void
    {
        foreach ($event->users as $user) {
            Notification::send($user, new SendMailReminderUserForContinueCoursesNotification($user));
        }
    }
}
