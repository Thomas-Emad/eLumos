<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NotificationResource;

class NotificationContoller extends Controller
{
  public function index(): View
  {
    return view('pages.dashboard.notifications');
  }

  public function getNotifications(Request $request)
  {
    if (!request()->ajax() || !Auth::check()) {
      return abort(404);
    }

    $notifications = Auth::user()->notifications()->latest()->get();
    $notifications->markAsRead();

    return response()->json([
      'notifys' =>  NotificationResource::collection($notifications)
    ]);
  }
}
