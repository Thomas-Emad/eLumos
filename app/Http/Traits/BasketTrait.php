<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

trait BasketTrait
{

  /**
   * Get content of Basket from Cookie
   *
   * @return array
   */
  private function getCookiesBasket(): array
  {
    // Get Content Basket
    if (Cookie::has('baskets')) {
      $baskets = unserialize(request()->cookie('baskets'));
    } else {
      cookie('baskets', serialize([]), 60 * 24 * 6);
      $baskets = [];
    }

    return $baskets;
  }

  /**
   * Get content of Basket from Authentication
   *
   * @return array
   */
  private function getAuthBasket(): array
  {
    return Auth::user()->baskets->pluck('course_id')->toArray();
  }

  /**
   * Add course to Basket.
   *
   * If the user is authenticated, we create a new basket item in the database.
   * If the user is not authenticated, we add the course to the cookie.
   *
   * @param array $baskets
   * @param string $id
   * @return array
   */
  private function addCoursesBasket(array $baskets, string $id): array
  {
    if (Auth::check()) {
      Auth::user()->baskets()->create([
        'course_id' => $id
      ]);
    }

    return array_merge($baskets, [$id]);
  }

  /**
   * Remove course from Basket.
   *
   * If the user is authenticated, we delete the basket item from the database.
   * If the user is not authenticated, we remove the course from the cookie.
   *
   * @param array $baskets
   * @param string $id
   * @return array
   */
  private function removeCoursesBasket(array $baskets, string $id): array
  {
    if (Auth::check()) {
      Auth::user()->baskets()->where('course_id', $id)->delete();
    }

    return array_diff($baskets, [$id]);
  }
}
