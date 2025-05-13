<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $cities = City::select('id', 'name')->get();

        return Inertia::render('auth/Register', [
            'cities' => $cities
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'birthday' => 'required|date',
            'city_id' => 'required|exists:cities,id',
            'gender' => 'required|in:male,female',
            'role' => 'required|in:employee,employer',
            'phone' => 'required|max:20',
            'image' => 'required|image|max:10240',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('profile', $imageName, 'public');
        } else {
            return redirect()->back()->with('error', 'No valid file uploaded.');
        }


        $cityName = City::where('id', $request->city)->value('name');
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'city_id' => $request->city_id,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'role' => $request->role,
            'phone' => $request->phone,
            'image' => $path,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('profilePage', absolute: false));
    }
}