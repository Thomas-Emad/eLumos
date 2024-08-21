<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.join');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_register' => ['required', 'string', 'max:255'],
            'email_register' => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password_register' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_register_confirmation' => ['required'],
            'role_register' => ['required', 'in:instructor,student'],
            'terms_register' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name_register,
            'email' => $request->email_register,
            'password' => Hash::make($request->password_register),
        ]);

        $user->assignRole($request->role_register);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
