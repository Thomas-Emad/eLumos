<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::view("courses", 'courses')->name("courses");
Route::view("course-details", 'course-details')->name("course-details");

// Route::group(['middleware' => 'auth'], function () {
Route::get('dashboard/{page?}', function ($page = 'home') {
    if (view()->exists('dashboard.' . $page)) {
        return  view('dashboard.' . $page);
    } else {
        return abort(404);
    }
})->name('dashboard');

Route::view('dashboard/profile', 'dashboard.profile')->name('profile');
Route::view('dashboard/add-course', 'dashboard.add-course')->name('add-course');
// });


require __DIR__ . '/auth.php';
