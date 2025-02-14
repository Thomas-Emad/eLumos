<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Models\CoursesEnrolled;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\CoursesEnrolledService;
use App\Http\Resources\CoursesEnrolledResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Actions\QRCodeGeneratorAction;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\Middleware;

class CoursesEnrolledController extends Controller implements HasMiddleware
{

  protected array $getStatus = [
    'all' => ['new', 'completed', 'incomplete'],
    'active' => ['new', 'incomplete'],
    'completed' => ['completed']
  ];

  public static function middleware(): array
  {
    return [
      new Middleware('permission:buy-courses', except: ['certificate']),
    ];
  }

  /**
   * Display the student's courses list with status counts.
   *
   * This function counts the occurrences of each course status for the authenticated user 
   * and returns a view with the count data.
   *
   * @return \Illuminate\View\View The courses list view with status counts.
   */
  public function index(): View
  {
    $courses = CoursesEnrolled::where('user_id', auth()->id())->select('status')->pluck('status');

    // Initialize the $countCourses array with keys from $this->getStatus and values set to 0
    $countCourses = array_fill_keys(array_keys($this->getStatus), 0);

    // Loop through the statuses and count occurrences
    foreach ($courses as $status) {
      foreach ($this->getStatus as $key => $statuses) {
        if (in_array($status, $statuses)) {
          $countCourses[$key]++;
        }
      }
    }

    return view('pages.dashboard.student.courses-list', ['countCourses' => $countCourses]);
  }

  /**
   * Retrieve and cache the list of courses for the authenticated user.
   *
   * This function checks if the request is AJAX, retrieves courses based on the selected type, 
   * caches the results for 1 hour, and returns the course data along with pagination information.
   * In case of an error, it returns a JSON response with the error message.
   *
   * @return \Illuminate\Http\JsonResponse JSON response with course data and pagination info.
   */
  public function getCourses(): \Illuminate\Http\JsonResponse|View
  {
    if (!request()->ajax()) {
      return abort(404);
    }

    try {
      // Cache Courses
      $type = in_array(request()->input('type'), array_keys($this->getStatus)) ? request()->input('type') : 'all';

      $courses = Cache::remember("courses.preview.$type." . auth()->id(), 3600, function () use ($type) {
        $data = CoursesEnrolled::with([
          'user:id,name,headline,photo',
          'course:id,title,mockup,user_id,average_rating'
        ])->select('id', 'course_id', 'user_id', 'progress_lectures')
          ->where('courses_enrolleds.user_id', auth()->id())
          ->whereIn('courses_enrolleds.status', $this->getStatus[$type])
          ->orderBy('buyer_at')
          ->paginate(10);
        return CoursesEnrolledResource::collection($data);
      });
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }

    return response()->json([
      'count' => $courses->total(),
      'courses' =>  $courses,
      'pagination' =>  [
        'first_page' => 1,
        'current_page' => $courses->currentPage(),
        'last_page' => $courses->lastPage(),
      ],
    ]);
  }

  /**
   * Show the course playlist.
   *
   * @param  string  $course
   * @param  string  $lecture
   * @return \Illuminate\Http\Response
   */
  public function show(CoursesEnrolledService $courseService, string $course, string $lecture = null)
  {
    $courseStudent = $courseService->getCourseEnrolled($course);
    $reviewStudent = $courseStudent->course->reviews()->where('user_id', Auth::id())->first();
    $currentLecture =  $courseService->getCurrentLectureFromAll($courseStudent, $lecture);
    $nextLecture =  $courseService->getNextLectureFromAll($courseStudent, $currentLecture->id);
    $setTimeOutForWatchLecture = $courseService->setTimeOutForWatchLecture($currentLecture);

    return view(
      'pages.dashboard.student.playlist',
      compact(
        'courseStudent',
        'currentLecture',
        'nextLecture',
        'setTimeOutForWatchLecture',
        'reviewStudent'
      )
    );
  }
  /**
   * Display the certificate page with QR code.
   *
   * This function retrieves the certificate details by its ID and generates a QR code 
   * for the certificate URL. It then returns a view displaying the certificate and QR code.
   *
   * @param int $certificateId The ID of the certificate.
   * @return \Illuminate\View\View The view displaying the certificate and QR code.
   */
  public function certificate($certificateId): View
  {
    $certificate = $this->certificateDetails($certificateId);
    $qrCode = (new QRCodeGeneratorAction)->generate(50, $certificate->url_share);
    return view('pages.dashboard.student.certificate', compact('certificate', 'qrCode'));
  }

  /**
   * Get the certificate modal content.
   *
   * This function handles the AJAX request to fetch the certificate modal content. 
   * It retrieves the certificate details based on the provided certificate ID 
   * and generates a QR code for the certificate URL. The content of the modal 
   * is then returned as a JSON response.
   *
   * @param \Illuminate\Http\Request $request The HTTP request instance.
   * @return \Illuminate\Http\JsonResponse JSON response containing the modal content.
   */
  public function getCertificateModal(Request $request): \Illuminate\Http\JsonResponse|View
  {
    if (!request()->ajax()) {
      return abort(404);
    }
    $certificate = $this->certificateDetails($request->certificate_id);
    $qrCode = (new QRCodeGeneratorAction)->generate(50,  $certificate->url_share);

    $content = view('pages.dashboard.student.partials.certificate-modal', compact('certificate', 'qrCode'))->render();
    return response()->json([
      'content' => $content
    ]);
  }

  /**
   * Retrieve the details of a certificate.
   *
   * This function fetches the details of a certificate, including the associated user's 
   * information, course title, and enrollment dates. It returns the details as an object.
   *
   * @param int $certificateID The ID of the certificate.
   * @return object The details of the certificate, including user name, course title, 
   *                enrollment dates, and certificate URL.
   */
  private function certificateDetails($certificateID): object
  {
    $enrolled = CoursesEnrolled::with([
      'user:id,username,name',
      'course:id,title'
    ])->where('certificate_id', $certificateID)->firstOrFail();

    return (object) [
      'id' => $certificateID,
      'start_date' => Carbon::parse($enrolled->created_at)->format("Y/m/d"),
      'completed_at' => Carbon::parse($enrolled->completed_at)->format("Y/m/d"),
      'completed_year' => Carbon::parse($enrolled->completed_at)->format("Y"),
      'url_share' => route('student.certificate', $certificateID),
      'user_name' => $enrolled->user->name,
      'course_title' => $enrolled->course->title,
    ];
  }
}
