<?php

namespace App\Http\Controllers;

use App\Http\Resources\BasketCoursesResource;
use App\Models\Basket;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class BasketController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }


  public function getData()
  {
    $baskets = $this->getCookiesBasket();
    $courses = Course::whereIn('id', $baskets)->get();
    return response()->json([
      'courses' => BasketCoursesResource::collection($courses)
    ]);
  }



  public function setData(Request $request)
  {

    if (Auth::check()) {
      // Code for authenticated users...
    } else {
      $baskets = $this->getCookiesBasket();

      // Set New Course in Basket
      if (!is_null($request->id) && !in_array($request->id, $baskets)) {
        $baskets = array_merge($baskets, [$request->id]);
        $messageButton = 'Remove from Cart';
      } else {
        $baskets = $this->removeCoursesBasket($baskets, $request->id);
        $messageButton = 'Add To Cart';
      }

      // Return the basket data
      return response()->json([
        'baskets' => $baskets,
        'message' => $messageButton
      ])->cookie('baskets', serialize($baskets), 60 * 24);
    }
  }

  private function getCookiesBasket(): array
  {
    // Get Content Basket
    if (Cookie::has('baskets')) {
      $baskets = unserialize(request()->cookie('baskets'));
    } else {
      cookie('baskets', serialize([]), 60 * 24 * 10000);
      $baskets = [];
    }

    return $baskets;
  }

  private function removeCoursesBasket(array $baskets, string $id): array
  {
    return array_diff($baskets, [$id]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Basket $basket)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Basket $basket)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Basket $basket)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Basket $basket)
  {
    //
  }
}
