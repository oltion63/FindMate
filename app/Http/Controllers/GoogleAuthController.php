<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $fullName = $user->name;
            [$firstName, $lastName] = array_pad(explode(' ', $fullName, 2), 2, null);
            $authUser = User::firstOrCreate(
                ['google_id' => $user->id],
                [
                    'name' => $firstName,
                    'lastname' => $lastName,
                    'email' => $user->email,
                    'image' => $user->avatar,
                    'password' => bcrypt('default_password'),
                    'role' => 'employee',
                    'email_verified_at' => now(),
                ],
            );
            Auth::login($authUser);
            return redirect()->intended(route('jobs.index', absolute: false));
        } catch (Exception $e) {
            return redirect('/login')->withErrors('Google authentication failed!');
        }
    }
}
