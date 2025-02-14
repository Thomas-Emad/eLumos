<?php

namespace App\Jobs;

use App\Models\User;
use App\Events\ReminderUserForContinueCoursesEvent;

class ReminderUserForContinueCoursesJob
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::with([
            'enrolled:user_id,course_id,progress_lectures,updated_at',
            'enrolled.course:id,title,headline'
        ])
            ->select('id', 'email', 'name')
            ->whereHas('enrolled', function ($query) {
                $query->where('courses_enrolleds.progress_lectures', '<=', 100)
                    ->whereRaw("DATE_ADD(courses_enrolleds.updated_at, INTERVAL 7 DAY) <= ?", [now()->toDateString()])
                    ->whereRaw("DATE_ADD(courses_enrolleds.updated_at, INTERVAL 3 WEEKS) >= ?", [now()->toDateString()]);
            })
            ->get();

        if ($users->isNotEmpty()) {
            event(new ReminderUserForContinueCoursesEvent($users));
        }
    }
}
