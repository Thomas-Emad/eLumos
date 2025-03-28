<?php

use Illuminate\Support\Facades\Route;
use App\Classes\Payment\StripePaymentGateway;
use App\Http\Controllers\{HomeController,  CategoryController, StepsForwardController, ProfileController};
use App\Http\Controllers\Student\{CourseStudentController, BasketController, CheckoutController, WishlistController, PaymentController, PaymentWebhookController};
use App\Http\Controllers\Dashboard\{
  CourseReviewLogController,
  DashboardController,
  ReviewCourseController,
  NotificationContoller,
  Tickets\TicketController,
  Tickets\TicketMessageController,
  Tickets\TicketLogController,
  Blog\ArticleControlController
};
use App\Http\Controllers\Dashboard\Admin\{RoleController, CourseController as CourseAdminController, CustomizeLayoutController};
use App\Http\Controllers\Dashboard\Instructor\{CoursesController, CourseSectionsController, CourseLecturesController};
use App\Http\Controllers\Dashboard\Instructor\Exams\{ExamController, ExamQuestionController};
use App\Http\Controllers\Dashboard\Student\{CoursesEnrolledController, StudentExamController, WatchCourseLectureController};
use App\Http\Controllers\Blog\ArticleController;

// Basic Pages
Route::get('/', HomeController::class)->name('home');
Route::get('/categories', CategoryController::class)->name('categories');

Route::view('privacy', 'pages.privacy')->name('privacy');
Route::view('terms', 'pages.terms')->name('terms');

/* *******************Student************************* */
// Student Controllers
Route::controller(CourseStudentController::class)->group(function () {
  Route::get("courses",  'index')->name("courses");
  Route::get("course-details/{id?}",  'show')->name("course-details");
  Route::post("course-details/reviews",  'reviews')->name("course-details.reviews");
  Route::get("course-details/reviews/api/{courseId?}",  'getReviews')->name("api.course-details.reviews");
});

Route::middleware(['middleware' => 'step-forward'])->group(function () {
  // Wishlist
  Route::controller(WishlistController::class)->group(function () {
    Route::get('dashboard/wishlist', "index")->name('dashboard.wishlist');
    Route::post('course-details/{id?}/wishlist', "actionWishlist")->name('wishlist.controll');
    Route::post('course/wishlist/api', "actionWishlistApi")->name('api.wishlist.controll');
  });

  // Baskets
  Route::controller(BasketController::class)->group(function () {
    Route::get('/cart',  'index')->name('baskets');
    Route::get('/cart-get-data', 'getData')->name('basket.getData');
    Route::post('/cart-set-data', 'setData')->name('basket.setData');
    Route::delete('/cart/destory/{id}', 'destory')->name('basket.destory');
  });

  // Notifications
  Route::controller(NotificationContoller::class)->group(function () {
    Route::get('/notifications', 'index')->name('notifications.index');
    Route::get('/get-notifications', 'getNotifications')->name('notifications.api');
  });

  // Payment, Checkout
  Route::post('/checkout/payment', [CheckoutController::class, 'viewPayment'])->name('checkout.viewPayment');
  Route::post('/checkout/processPayment/intent', [StripePaymentGateway::class, 'paymentIntent'])->name('checkout.processPayment.stripe.intent');
  Route::get('/checkout/payment/callback/{gateway?}', [PaymentController::class, 'callback'])->name('checkout.callback');
  Route::get('/payment/success/', [PaymentController::class, 'success'])->name('checkout.success');
  Route::get('/payment/pending/', [PaymentController::class, 'pending'])->name('checkout.pending');
  Route::get('/payment/fail/', [PaymentController::class, 'fail'])->name('checkout.fail');
  Route::get('/payment/canceled/', [PaymentController::class, 'canceled'])->name('checkout.canceled');
});
Route::post('/payment/webhook/stripe', [PaymentWebhookController::class, 'handleStripeWebhook'])->name('checkout.stripe.webhook');
Route::post('/payment/webhook/paypal', [PaymentWebhookController::class, 'handlePaypalWebhook'])->name('checkout.paypal.webhook');

/* Sharing link Certificate */
Route::get('/certificate/{id}', [CoursesEnrolledController::class, 'certificate'])->name('student.certificate');
Route::get('courses-list/certificate', [CoursesEnrolledController::class, 'getCertificateModal'])->name('student.certificate.modal');


Route::group(['middleware' => 'step-forward', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
  // Previous Orders, Payments
  Route::get('/payments', [PaymentController::class, 'index'])->name('orders.index');
  Route::get('/api/payments/show/{id?}', [PaymentController::class, 'show'])->name('orders.show.api');
  Route::get('/pdf/payments/show/{id?}', [PaymentController::class, 'donwloadInovicePDF'])->name('orders.show.pdf');

  // Course Pages for Student Courses
  Route::controller(CoursesEnrolledController::class)->group(function () {
    Route::get('/courses-list',  'index')->name('courses-list');
    Route::get('/courses-list/show/courses/{type?}',  'getCourses')->name('courses-list.show');
    Route::get('/courses-list/{course}/{lecture?}',  'show')->name('student.show');
  });
  Route::post('/courses-list/lecture/watch',  [WatchCourseLectureController::class, '__invoke'])->name('student.lecture.watch');

  // Exam For Courses
  Route::controller(StudentExamController::class)->group(function () {
    Route::get('/student/exams',  'index')->name('student.exams.index');
    Route::get('/student/exams/{exam}', 'edit')->name('student.exams.test');
    Route::post('/student/exams/store', 'store')->name('student.exams.store');
    Route::patch('/student/exams/{exam}/send', 'update')->name('student.exams.update');
    Route::get('/student/exams/{session}/report', 'report')->name('student.exams.report');
    Route::get('/student/exams/{session}/done', 'done')->name('student.exams.done');
    Route::view('/student/exams/{session}/expired', 'pages.dashboard.student.exams.alerts.expired')->name('student.exams.expired');
  });

  Route::resource("/course/reviews", ReviewCourseController::class);
  Route::post("course/reviews/statistics", [ReviewCourseController::class, 'getStatisticsRate'])->name('reviews.get-statistics');
});

Route::group(['middleware' => 'auth', 'middleware' => 'verified'], function () {
  // Pages steps forward
  Route::controller(StepsForwardController::class)->group(function () {
    Route::get('/steps-forward/{page?}', 'index')->name('steps-forward');
    Route::post('/steps-forward/save', 'save')->name('steps-forward.save');
  });

  // Check From Steps Forward to get executed information
  Route::group(['middleware' => 'step-forward', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/', [DashboardController::class, "__invoke"])->name('index');
    Route::get('/profile/{id?}', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');

    /* *******************instructor************************* */
    // instructor Controllers
    Route::resource('/courses', CoursesController::class)->names('instructor.courses')->except('show');
    Route::controller(CoursesController::class)->as('instructor.')->group(function () {
      Route::get('/courses/status/{id}',  'status')->name('courses.status');
      Route::get('/courses/tracking/{id}', 'statistics')->name('courses.tracking');
      Route::get('/support',  'support')->name('support');
    });
    Route::get('/api/courses/show/{type?}',  [CoursesController::class, 'getCourses'])->name('api.instructor.courses.show');

    // Api CRUD Operations for Course Sections
    Route::put('/api/courses/sections/change-sort-section', [CourseSectionsController::class, 'changeSortSection'])->name('api.instructor.courses.sections.changeSortSection');
    Route::apiResource('/api/courses/sections', CourseSectionsController::class)->names('api.instructor.courses.sections');

    // Api CRUD Operations for Course Lectures
    Route::apiResource('/api/courses/lectures', CourseLecturesController::class)->names('api.instructor.courses.lectures');

    // Exams
    Route::prefix('instructor')->as("instructor.")->group(function () {
      Route::resource('exams', ExamController::class)->names('exams')->only(['index', 'store', 'show', 'destroy']);
      Route::resource('exam/questions', ExamQuestionController::class)->names('exams.questions')->only(['store', 'show', 'destroy']);
      Route::get('exam/questions/component/{type?}',  [ExamQuestionController::class, 'getComponent'])->name('exams.get-component');
      Route::post('exams/question/answer-student', [StudentExamController::class, 'getInfoQuestion'])->name('exams.get-info-question');
      Route::post('exams/question/correct-answer', [StudentExamController::class, 'correctAnswer'])->name('exams.correct-answer');
    });
  });

  /* *******************Admin************************* */
  // Role Pages for owner role
  Route::resource('dashboard/roles', RoleController::class)->only(['index', 'store', 'update', 'destroy']);
  Route::controller(RoleController::class)->group(function () {
    Route::post('dashboard/role/', 'showRole')->name('roles.showRole');
    Route::get('dashboard/role/users', 'users')->name('roles.users');
    Route::post('dashboard/role/user/change', 'changeRoleUser')->name('roles.users.change');
  });

  // Course Pages for Admin
  Route::controller(CourseAdminController::class)->group(function () {
    Route::get('dashboard/admin/courses', 'index')->name('dashboard.admin.courses');
    Route::get('dashboard/admin/show/course', 'show')->name('dashboard.admin.show.course');

    Route::post('dashboard/admin/courses', 'reviewStatusCourse')->name('dashboard.admin.courses.review-course');
  });

  // Reviews Log For Course
  Route::controller(CourseReviewLogController::class)->group(function () {
    Route::get('dashboard/review/log/index', 'index')->name('dashboard.review.log.index');
    Route::get('dashboard/review/log/show', 'show')->name('dashboard.review.log.show');
    Route::post('dashboard/review/log/update', 'store')->name('dashboard.review.log.update');
  });

  // Support
  Route::resource('dashboard/tickets', TicketController::class)
    ->middleware("step-forward")->names('dashboard.tickets');
  Route::group(['middleware' => 'step-forward', 'prefix' => 'dashboard/tickets', 'as' => 'dashboard.tickets'], function () {
    Route::post('send', [TicketMessageController::class, 'broadcast'])->name('send');
    Route::post('receiver', [TicketMessageController::class, 'receiver'])->name('receiver');
    Route::post('review', [TicketController::class, 'review'])->name('review');
    Route::post('change-status', [TicketLogController::class, 'changeStatus'])->name('changeStatus');
    Route::post('change-priority', [TicketLogController::class, 'changePriority'])->name('changePriority');
  });
  Route::get('tickets/table', [TicketController::class, 'table'])->name('dashboard.tickets.table');
  Route::get('tickets/logs', [TicketLogController::class, 'logs'])->name('dashboard.tickets.logs');

  /* Blog Module => Article */
  Route::resource("dashboard/articles", ArticleControlController::class)
    ->names("dashboard.articles")
    ->middleware('step-forward');
});

/* Blog Module => Article */
Route::controller(ArticleController::class)->group(function () {
  Route::get('blog/search', 'index')->name('articles.index');
  Route::get('blog/{article:slug}', 'show')->name('articles.show');
});



require __DIR__ . '/auth.php';
