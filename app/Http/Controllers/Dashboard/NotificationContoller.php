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
    $notifications = Auth::user()->notifications()->latest()->paginate(20);
    $notifications->markAsRead();
    return view('pages.dashboard.notifications', compact('notifications'));
  }

  public function getNotifications()
  {
    if (!request()->ajax() || !Auth::check()) {
      return abort(404);
    }

    $notifications = Auth::user()->notifications()->latest()->limit(10)->get();
    $notifications->markAsRead();

    return response()->json([
      'notifys' =>  NotificationResource::collection($notifications)
    ]);
  }
}
