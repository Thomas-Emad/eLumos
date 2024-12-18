<?php

namespace App\Http\Controllers\Student;

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
    $wishlists = Auth::user()->wishlist()->with('course')->withoutTrashed()->paginate(10);
    return view('pages.student.wishlists', compact('wishlists'));
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

    if ($wishlist->exists) {
      if (!is_null($wishlist->deleted_at)) {
        $wishlist->restore();
      } else {
        $wishlist->delete();
      }
    } else {
      $wishlist->save();
    }

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "We Will done as Well.."
    ]);
  }


  public function actionWishlistApi(Request $request)
  {
    if (!request()->ajax() || !isset($request->course_id)) {
      return abort(404);
    }

    $wishlist = Auth::user()->wishlist()->firstOrNew(
      ['course_id' => $request->course_id],
      ['user_id' => Auth::user()->id]
    );

    if ($wishlist->exists) {
      if (!is_null($wishlist->deleted_at)) {
        $wishlist->restore();
        $type = 'add';
      } else {
        $wishlist->delete();
        $type = 'remove';
      }
    } else {
      $wishlist->save();
      $type = 'add';
    }

    return response()->json([
      'type' => $type,
      'message' => "We Will done as Well.."
    ]);
  }
}
