<?php

namespace App\Http\Controllers;

use App\Http\Resources\BasketCoursesResource;
use App\Models\Basket;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\http\Traits\BasketTrait;

class BasketController extends Controller
{
  use BasketTrait;

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $baskets = Auth::check() ? $this->getAuthBasket() : $this->getCookiesBasket();
    return view('basket', compact('baskets'));
  }

  /**
   * Get all courses in the user's basket.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function getData()
  {
    $baskets = Auth::check() ? $this->getAuthBasket() : $this->getCookiesBasket();
    $courses = Course::whereIn('id', $baskets)->get();
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
      $baskets = $this->removeCoursesBasket($baskets, $request->id);
      $messageButton = 'Add To Cart';
    } else {
      $baskets = $this->addCoursesBasket($baskets, $request->id);
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
}
