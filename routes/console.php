<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\ReminderUserForContinueCoursesJob;

Schedule::job(new ReminderUserForContinueCoursesJob)->weeklyOn(1, "00:00");
