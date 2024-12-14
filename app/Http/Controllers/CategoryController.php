<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\TopCategoiresUsedAction;

class CategoryController extends Controller
{

  public function __invoke()
  {
    $topCatgeoiresUsed = (new TopCategoiresUsedAction)->getTopCategoires(20);
    return view('pages.categoires', compact('topCatgeoiresUsed'));
  }
}
