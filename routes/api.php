<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursesController;

// get Courses By Status
Route::get('courses/show/{type?}',  [CoursesController::class, 'getCourses'])->name('api.dashboard.courses.show');
