<?php

namespace App\Http\Controllers\Student;

use App\Factories\PaymentGatewayFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;

class CheckoutController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return [
      'permission:buy-courses',
    ];
  }

  private function orders()
  {
    $courses = Auth::user()->basketWithCourses()->select('courses.id', 'courses.price')->where('status', 'active')->get('id', 'price');
    return $courses;
  }

  public function viewPayment(Request $request)
  {
    $request->gateway = $request->gateway ?? 'stripe';
    $gateway = PaymentGatewayFactory::make($request->gateway);

    return $gateway->view($this->orders());
  }
}
