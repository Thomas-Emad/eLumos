<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StepsForwardController;




// Basic Pages
Route::view('/', 'home')->name('home');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('terms', 'terms')->name('terms');
Route::view("courses", 'courses')->name("courses");
Route::view("course-details", 'course-details')->name("course-details");


Route::group(['middleware' => 'auth', 'middleware' => 'verified'], function () {
    // Pages steps forward
    Route::controller(StepsForwardController::class)->group(function () {
        Route::get('/steps-forward/{page?}', 'index')->name('steps-forward');
        Route::post('/steps-forward/save', 'save')->name('steps-forward.save');
    });

    // Check From Steps Forward to get executed information
    Route::middleware('step-forward')->group(function () {
        Route::view('dashboard/', 'dashboard.home')->name('dashboard');
        Route::view('dashboard/profile', 'dashboard.profile')->name('dashboard.profile');
        Route::view('dashboard/add-course', 'dashboard.add-course')->name('dashboard.add-course');
        Route::view('dashboard/courses-list', 'dashboard.courses-list')->name('dashboard.courses-list');
        Route::view('dashboard/my-courses', 'dashboard.my-courses')->name('dashboard.my-courses');
    });

    // Role Pages for owner role
    Route::resource('dashboard/roles', RoleController::class);
    Route::post('dashboard/role/', [RoleController::class, 'showRole'])->name('roles.showRole');
    Route::get('dashboard/role/users', [RoleController::class, 'users'])->name('roles.users');
    Route::post('dashboard/role/user/change', [RoleController::class, 'changeRoleUser'])->name('roles.users.change');
});





// Route::get('dashboard/{page?}', function ($page = 'home') {
//     if (view()->exists('dashboard.' . $page)) {
//         return  view('dashboard.' . $page);
//     } else {
//         return abort(404);
//     }
// })->name('dashboard');


require __DIR__ . '/auth.php';
