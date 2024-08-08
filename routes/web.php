<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');





Route::view("courses", 'courses')->name("courses");
Route::view("course-details", 'course-details')->name("course-details");



Route::view('dashboard/profile', 'dashboard.profile')->name('profile');
Route::view('dashboard/add-course', 'dashboard.add-course')->name('add-course');
Route::view('dashboard/courses-list', 'dashboard.courses-list')->name('courses-list');
Route::view('dashboard/my-courses', 'dashboard.my-courses')->name('my-courses');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('terms', 'terms')->name('terms');

// Admin Page
Route::group(['middleware' => 'auth'], function () {
    Route::resource('dashboard/roles', RoleController::class);
    Route::post('dashboard/role/', [RoleController::class, 'showRole'])->name('roles.showRole');
    Route::get('dashboard/role/users', [RoleController::class, 'users'])->name('roles.users');
    Route::post('dashboard/role/user/change', [RoleController::class, 'changeRoleUser'])->name('roles.users.change');
});


Route::get('dashboard/{page?}', function ($page = 'home') {
    if (view()->exists('dashboard.' . $page)) {
        return  view('dashboard.' . $page);
    } else {
        return abort(404);
    }
})->name('dashboard');


require __DIR__ . '/auth.php';
