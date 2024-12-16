<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
  public function redirect($way)
  {
    return Socialite::driver($way)->redirect();
  }

  public function callback($way)
  {
    $OAuthUser = Socialite::driver($way)->stateless()->user();
    $user = User::firstOrCreate([
      'email' => $OAuthUser->email,
    ], [
      'name' => $OAuthUser->name,
      'email' => $OAuthUser->email,
      'oauth_id' => $OAuthUser->id,
      'oauth_provider' => $way,
      'oauth_token' => $OAuthUser->token,
      'steps_forward' => 'type-user',
    ]);

    Auth::login($user);

    return redirect()->route("steps-forward", 'type-user');
  }
}
