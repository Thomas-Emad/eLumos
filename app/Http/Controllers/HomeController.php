<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Actions\TopCategoiresUsedAction;

class HomeController extends Controller
{
  public function __invoke()
  {
    $topCatgeoiresUsed = Cache::remember('home.categories', 3600 * 24 * 6, function () {
      return (new TopCategoiresUsedAction)->getTopCategoires(6);
    });;
    return view('pages.home', compact('topCatgeoiresUsed'));
  }
}
