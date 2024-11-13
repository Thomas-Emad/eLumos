<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\BasketCoursesResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\http\Traits\BasketTrait;
use Illuminate\Routing\Controllers\HasMiddleware;

class BasketController extends Controller implements HasMiddleware
{
  use BasketTrait;

  public static function middleware(): array
  {
    return [
      'permission:buy-courses',
    ];
  }


  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $baskets = Auth::check() ? $this->getAuthBasket() : $this->getCookiesBasket();
    $courses = Course::with(['lectures', 'user'])->where('status', 'active')->whereIn('id', $baskets)->select('id', 'title', 'price', 'level', 'mockup', 'user_id')->get();
    return view('pages.student.basket', compact('courses'));
  }

  /**
   * Get all courses in the user's basket.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function getData()
  {
    $baskets = Auth::check() ? $this->getAuthBasket() : $this->getCookiesBasket();
    $courses = Course::where('status', 'active')
      ->whereIn('id', $baskets)->select('id', 'title', 'price', 'mockup')->get();

    return response()->json([
      'courses' => BasketCoursesResource::collection($courses)
    ]);
  }

  /**
   * Add or Remove course from Basket of User
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function setData(Request $request)
  {
    $baskets = Auth::check() ? $this->getAuthBasket() : $this->getCookiesBasket();

    if (
      (Auth::check() && Auth::user()->baskets()->where('course_id', $request->id)->exists())
      || (!is_null($request->id) && in_array($request->id, $baskets))
    ) {
      $baskets = $this->removeCourseBasket($baskets, $request->id);
      $messageButton = 'Add To Cart';
    } else {
      $baskets = $this->addCourseBasket($baskets, $request->id);
      $messageButton = 'Remove from Cart';
    }

    // Return the basket data
    $jsonResponse = [
      'baskets' => $baskets,
      'message' => $messageButton
    ];

    if (Auth::check()) {
      return response()->json($jsonResponse)->cookie('baskets', serialize($baskets), 60 * 24 * 6);
    } else {
      return response()->json($jsonResponse)->cookie('baskets', serialize($baskets), 60 * 24 * 6);
    }
  }

  /**
   * Destroy the specified resource in storage.
   *
   * @param  string  $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destory(string $id)
  {
    Auth::user()->baskets()->where('course_id', $id)->delete();

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => 'Course removed successfully from Your Cart..'
    ]);
  }
}
