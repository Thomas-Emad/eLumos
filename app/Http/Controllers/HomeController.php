<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\TopCategoiresUsedAction;

class HomeController extends Controller
{
  public function __invoke()
  {
    $topCatgeoiresUsed = (new TopCategoiresUsedAction)->getTopCategoires(6);
    return view('pages.home', compact('topCatgeoiresUsed'));
  }
}
