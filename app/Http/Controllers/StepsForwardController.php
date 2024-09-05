<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StepsForwardController extends Controller
{
  /**
   * index function
   *
   * @return View
   */
  public function index(): View
  {
    if (
      Auth::user()->steps_forward != 'complate' || session('notification') != null
    ) {
      return view('steps-forward.index');
    } else {
      return redirect()->route('dashboard');
    }
  }

  /**
   * save function
   *
   * @param Request $request
   * @return void
   */
  public function save(Request $request)
  {
    if ($request->input('step') == 'new') {
      return  $this::newUserStep($request);
    } elseif ($request->input('step') == 'info') {
      return  $this::infoUserStep($request);
    } else {
      return abort(404);
    }
  }

  /**
   * newUserStep function
   *
   * @param Request $request
   * @return void
   */
  private static function newUserStep(Request $request)
  {
    try {
      $request->validate([
        'username' => ['required', 'min:3', 'max:20', 'unique:users,username', 'alpha_dash:ascii'],
        'photo' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        'tags' => ['required', 'array', 'between:3,10'],
      ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return redirect()->back()->withErrors($e->errors())
        ->withInput()->with('notification', [
          'type' => 'fail',
          'message' => 'Error in verifying data'
        ]);
    }

    $pathPhoto = $request->file('photo')->store('users', 'public');

    // Update info than add tags
    $user = Auth::user();
    $steps_forward = $user->hasRole('instructor') ? 'info' : 'complate';
    $user->update([
      'steps_forward' =>  $steps_forward,
      'username' => $request->input('username'),
      'photo' => $pathPhoto,
    ]);
    $user->tags()->sync($request->input('tags')); // Sync tags

    return redirect()->route('steps-forward',  $steps_forward)->with('notification', [
      'type' => 'success',
      'message' => 'You are all set!'
    ]);
  }

  /**
   * infoUserStep function
   *
   * @param Request $request
   * @return void
   */
  private static function infoUserStep(Request $request)
  {
    $request->validate([
      'headline' => ['required', 'min:3', 'max:50', 'string'],
      'description' => ['nullable', 'min:3', 'max:2000', 'string'],
    ]);

    $user = Auth::user();
    $user->update([
      'headline' => $request->input('headline'),
      'description' => $request->input('description'),
      'steps_forward' => 'complate',
    ]);
    return redirect()->route('steps-forward', 'complate')->with('notification', [
      'type' => 'success',
      'message' => 'You are all set!'
    ]);
  }
}
