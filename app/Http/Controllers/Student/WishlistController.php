<?php

namespace App\Http\Controllers\Student;

use App\Models\Wishlist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function actionWishlist(Request $request, string $id)
  {
    $wishlist = Auth::user()->wishlist()->firstOrNew(
      ['course_id' => $id],
      ['user_id' => Auth::user()->id]
    );


    if ($request->type == 'add') {
      $wishlist->delete();
    } elseif ($request->type == 'remove') {
      $wishlist->restore();
    }

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "We Will done as Well.."
    ]);
  }
}
