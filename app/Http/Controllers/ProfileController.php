<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Models\Application;
use App\Models\City;
use App\Models\Company;
use App\Models\CV;
use App\Models\Post;
use App\Models\SavedPosts;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(Request $request): Response
    {

        $user = $request->user()->load('company', 'city', 'cv');
        $company = Company::where('user_id', $user->id)->first();
        $currentUserId = auth()->id();
        $countApplied = Application::all()->where('user_id', $currentUserId)->count();
        $countPosts = Post::all()->where('user_id', $currentUserId)->count();
        $countSaved = SavedPosts::all()->where('user_id', $currentUserId)->count();
        $countApplications = Application::with('post')
            ->whereHas('post', function ($query) use ($currentUserId){
                $query->where('user_id', $currentUserId);
            })->count();
        $applications = Application::with(['post', 'user.cv'])
            ->whereHas('post', function ($query) use ($currentUserId) {
                $query->where('user_id', $currentUserId);
            })
            ->get();
        $employeeApplications = Application::with(['post.company', 'user'])
            ->where('user_id', $currentUserId, )->get();
        $currentCV = CV::where('user_id', $currentUserId)->value('file');
        $savedPosts = SavedPosts::with(['post.company', 'user'])
            ->where('user_id', $currentUserId, )->get();
        $employerPosts = Post::with(['category', 'location', 'company'])
            ->where('user_id', $currentUserId, )->get();

        return Inertia::render('profile/profile', [
            'applications' => $applications,
            'employeeApplications' => $employeeApplications,
            'company' => $company,
            'user' => $user,
            'city' => $user->city,
            'countApplied' => $countApplied,
            'currentCV' => $currentCV,
            'countPosts' => $countPosts,
            'countSaved' => $countSaved,
            'countApplications' => $countApplications,
            'savedPosts' => $savedPosts,
            'employerPosts' => $employerPosts,
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $cities = City::select('id', 'name')->get();
        $company = Company::where('user_id', $request->user()->id)->first();
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'company' => $company,
            'authUser' => $request->user()->id,
            'cities' => $cities,
            'city' => $request->user()->city,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData =$request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'birthday' => 'required',
            'city_id' => 'required|exists:cities,id',
            'gender' => 'required|in:male,female',
            'role' => 'required|in:employee,employer',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $user = $request->user();


        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user->update($validatedData);

        return Redirect::route('profile.edit');
    }

    public function updateImage(Request $request)
    {
        // Validate the image
        $request->validate([
            'image' => ['required', 'image', 'max:10240'], // Maximum 2MB
        ]);

        $user = $request->user(); // Get the authenticated user

        // Handle the existing profile image deletion if applicable
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('profile', $imageName, 'public');
            if ($user->image && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }
            $user->update([
                'image' => $path,
            ]);
            return back()->with('status', 'Profile image updated successfully.');
        }

        return back()->with('error', 'No image was uploaded!');

    }

    /**
     * Delete the user's account.
     */

}
