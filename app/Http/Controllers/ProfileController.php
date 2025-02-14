<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\InstructorCourseDetailsResource;
use App\Services\ProfileService;

class ProfileController extends Controller
{
  public function index(ProfileService $service, $username = null)
  {
    if (is_null($username)) {
      $username = Auth::user()->username;
    }

    $user = User::select('id', 'username', 'name',  'email', 'headline', 'username', 'photo', 'description', 'created_at', 'email_verified_at')
      ->with([
        'courses' => function ($query) {
          $query->with([
            'enrolleds:id,course_id',
            'lectures:id,course_id,video_duration',
          ])->where('status', 'active')
            ->withCount(['reviews as totalReviews'])
            ->withSum('reviews as totalRate', 'rate');
        },
      ])
      ->where('username', $username)
      ->firstOrFail();

    $courses = $user->courses;
    $tags = implode(', ', $user->tags->pluck('name')->toArray());
    $user =  $service->formatInstructor($user);

    return view("pages.dashboard.profile", compact('user', 'courses', 'tags'));
  }

  /**
   * Display the user's profile form.
   */
  public function edit(Request $request): View
  {
    return view('profile.edit', [
      'user' => $request->user(),
    ]);
  }

  /**
   * Update the user's profile information.
   */
  public function update(ProfileUpdateRequest $request): RedirectResponse
  {
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
      $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
  }

  /**
   * Delete the user's account.
   */
  public function destroy(Request $request): RedirectResponse
  {
    $request->validateWithBag('userDeletion', [
      'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }
}
