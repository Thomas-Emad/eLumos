<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admin\{RoleController, CourseController as DashboardCoursesController};
use App\Http\Controllers\{StepsForwardController};
use App\Http\Controllers\Dashboard\Instructor\{CoursesController, CourseSectionsController, CourseLecturesController};
use App\Http\Controllers\Dashboard\Instructor\Exams\{ExamController, ExamQuestionController};
use App\Http\Controllers\Dashboard\Student\{CoursesEnrolledController};
use App\Http\Controllers\Student\{CourseStudentController, BasketController, CheckoutController, WishlistController};




// Basic Pages
Route::view('/', 'pages.home')->name('home');
Route::view('privacy', 'pages.privacy')->name('privacy');
Route::view('terms', 'pages.terms')->name('terms');


/* *******************Student************************* */
// Student Controllers 
Route::get("courses", [CourseStudentController::class, 'index'])->name("courses");
Route::get("course-details/{id?}", [CourseStudentController::class, 'show'])->name("course-details");

// Wishlist 
Route::controller(WishlistController::class)->group(function () {
  Route::get('dashboard/wishlist', "index")->name('dashboard.wishlist');
  Route::post('course-details/{id?}/wishlist', "actionWishlist")->name('wishlist.controll');
});

// Baskets 
Route::controller(BasketController::class)->group(function () {
  Route::get('/cart',  'index')->name('baskets');
  Route::get('/cart-get-data', 'getData')->name('basket.getData');
  Route::post('/cart-set-data', 'setData')->name('basket.setData');
  Route::delete('/cart/destory/{id}', 'destory')->name('basket.destory');
});

// Checkout
Route::post('/checkout', [CheckoutController::class, 'saveCourses'])->name('checkout.saveCourses');

Route::group(['middleware' => 'step-forward', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
  // Course Pages for Student Courses
  Route::controller(CoursesEnrolledController::class)->group(function () {
    Route::get('/courses-list',  'index')->name('courses-list');
    Route::get('/courses-list/show/courses/{type?}',  'getCourses')->name('courses-list.show');
    Route::get('/courses-list/{course}/{lecture?}',  'show')->name('student.show')
      ->middleware('watch-course-lecture');
  });
});

Route::group(['middleware' => 'auth', 'middleware' => 'verified'], function () {
  // Pages steps forward
  Route::controller(StepsForwardController::class)->group(function () {
    Route::get('/steps-forward/{page?}', 'index')->name('steps-forward');
    Route::post('/steps-forward/save', 'save')->name('steps-forward.save');
  });

  // Check From Steps Forward to get executed information
  Route::group(['middleware' => 'step-forward', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::view('/', 'pages.dashboard.home')->name('index');
    Route::view('/profile/{id?}', 'pages.dashboard.profile')->name('profile');

    /* *******************instructor************************* */
    // instructor Controllers
    Route::resource('/courses', CoursesController::class)->names('instructor.courses');
    Route::get('/api/courses/show/{type?}',  [CoursesController::class, 'getCourses'])->name('api.instructor.courses.show');

    // Api CRUD Operations for Course Sections
    Route::put('/api/courses/sections/change-sort-section', [CourseSectionsController::class, 'changeSortSection'])->name('api.instructor.courses.sections.changeSortSection');
    Route::apiResource('/api/courses/sections', CourseSectionsController::class)->names('api.instructor.courses.sections');

    // Api CRUD Operations for Course Lectures
    Route::apiResource('/api/courses/lectures', CourseLecturesController::class)->names('api.instructor.courses.lectures');

    // Exams
    Route::resource('exams', ExamController::class)->names('instructor.exams');
    Route::resource('exam/questions', ExamQuestionController::class)->names('instructor.exams.questions');
    Route::get('exam/questions/component/{type?}',  [ExamQuestionController::class, 'getComponent'])->name('instructor.exams.get-component');
  });

  /* *******************Admin************************* */
  // Role Pages for owner role
  Route::resource('dashboard/roles', RoleController::class);
  Route::controller(RoleController::class)->group(function () {
    Route::post('dashboard/role/', 'showRole')->name('roles.showRole');
    Route::get('dashboard/role/users', 'users')->name('roles.users');
    Route::post('dashboard/role/user/change', 'changeRoleUser')->name('roles.users.change');
  });

  // Course Pages for Admin
  Route::controller(DashboardCoursesController::class)->group(function () {
    Route::get('dashboard/admin/courses', 'index')->name('dashboard.admin.courses');
    Route::post('dashboard/admin/courses', 'reviewStatusCourse')->name('dashboard.admin.courses.review-course');
  });
});



require __DIR__ . '/auth.php';
