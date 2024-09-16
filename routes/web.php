<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CourseSectionsController;
use App\Http\Controllers\StepsForwardController;
use App\Http\Controllers\CourseLecturesController;

// Basic Pages
Route::view('/', 'home')->name('home');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('terms', 'terms')->name('terms');
Route::view("courses", 'courses')->name("courses");
Route::view("course-details/{id?}", 'course-details')->name("course-details");


Route::group(['middleware' => 'auth', 'middleware' => 'verified'], function () {
  // Pages steps forward
  Route::controller(StepsForwardController::class)->group(function () {
    Route::get('/steps-forward/{page?}', 'index')->name('steps-forward');
    Route::post('/steps-forward/save', 'save')->name('steps-forward.save');
  });

  // Check From Steps Forward to get executed information

  Route::group(['middleware' => 'step-forward', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    // Course For Admin
    Route::controller(CoursesController::class)->group(function () {
      Route::get('/courses', 'index')->name('courses');
      Route::get('/add-course',  'create')->name('add-course');
      Route::post('/add-course',  'store')->name('add-course.store');
      Route::get('/course/{course}/edit',  'edit')->name('course.edit');
    });
    Route::prefix('api')->group(function () {
      Route::get('/show/courses/{type?}',  [CoursesController::class, 'getCourses'])->name('courses.show');

      // Api CRUD Operations for Course Sections
      Route::put('/course/sections/changeSortSection', [CourseSectionsController::class, 'changeSortSection'])->name('course.sections.changeSortSection');
      Route::apiResource('/course/sections', CourseSectionsController::class)->names([
        'index' => 'course.sections.index',
        'store' => 'course.sections.store',
        'update' => 'course.sections.update',
        'destroy' => 'course.sections.destroy',
      ]);

      // Api CRUD Operations for Course Lectures
      Route::apiResource('/course/lectures', CourseLecturesController::class)->names([
        'index' => 'course.lectures.index',
        'store' => 'course.lectures.store',
        'show' => 'course.lectures.show',
        'destroy' => 'course.lectures.destroy',
      ]);
      Route::put('/course/lectures/update', [CourseLecturesController::class, 'update'])->name('course.lectures.update-test');
    });

    Route::view('/', 'dashboard.home')->name('index');
    Route::view('/profile/{id?}', 'dashboard.profile')->name('profile');

    Route::view('/courses-list', 'dashboard.courses-list')->name('courses-list');
  });


  // Role Pages for owner role
  Route::resource('dashboard/roles', RoleController::class);
  Route::controller(RoleController::class)->group(function () {
    Route::post('dashboard/role/', 'showRole')->name('roles.showRole');
    Route::get('dashboard/role/users', 'users')->name('roles.users');
    Route::post('dashboard/role/user/change', 'changeRoleUser')->name('roles.users.change');
  });
});




// Route::get('dashboard/{page?}', function ($page = 'home') {
//     if (view()->exists('dashboard.' . $page)) {
//         return  view('dashboard.' . $page);
//     } else {
//         return abort(404);
//     }
// })->name('dashboard');


require __DIR__ . '/auth.php';
