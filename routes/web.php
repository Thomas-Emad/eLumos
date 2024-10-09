<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\{RoleController, CourseController as DashboardCoursesController};
use App\Http\Controllers\{StepsForwardController, BasketController, CheckoutController};
use App\Http\Controllers\Dashboard\{CoursesController, CourseSectionsController, CourseLecturesController, CoursesEnrolledController};
use App\Http\Controllers\Student\{CourseStudentController, WishlistController};

// Basic Pages
Route::view('/', 'home')->name('home');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('terms', 'terms')->name('terms');

// Baskets 
Route::get('/cart', [BasketController::class, 'index'])->name('baskets');
Route::get('/cart-get-data', [BasketController::class, 'getData'])->name('basket.getData');
Route::post('/cart-set-data', [BasketController::class, 'setData'])->name('basket.setData');
Route::delete('/cart/destory/{id}', [BasketController::class, 'destory'])->name('basket.destory');

// Student Controllers 
Route::get("courses", [CourseStudentController::class, 'index'])->name("courses");
Route::get("course-details/{id?}", [CourseStudentController::class, 'show'])->name("course-details");


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
      Route::patch('/course/{course}/update',  [CoursesController::class, 'update'])->name('courses.update');
      Route::delete('/course/destroy',  [CoursesController::class, 'destroy'])->name('courses.destroy');
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

    // Course Pages for Student Courses
    Route::controller(CoursesEnrolledController::class)->group(function () {
      Route::get('/courses-list',  'index')->name('courses-list');
      Route::get('/courses-list/show/courses/{type?}',  'getCourses')->name('courses-list.show');
    });
  });

  // Student Controllers 
  Route::controller(WishlistController::class)->group(function () {
    Route::get('dashboard/wishlist', "index")->name('dashboard.wishlist');
    Route::post('course-details/{id?}/wishlist', "actionWishlist")->name('wishlist.controll');
  });

  // CheckOut Courses
  Route::post('/checkout', [CheckoutController::class, 'saveCourses'])->name('checkout.saveCourses');


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




// Route::get('dashboard/{page?}', function ($page = 'home') {
//     if (view()->exists('dashboard.' . $page)) {
//         return  view('dashboard.' . $page);
//     } else {
//         return abort(404);
//     }
// })->name('dashboard');



require __DIR__ . '/auth.php';
