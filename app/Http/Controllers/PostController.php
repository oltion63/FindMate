<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Post;
use App\Models\SavedPosts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $cities = City::all();

        $baseQuery = Post::query();
        if ($request->has('location') && $request->location) {
            $baseQuery->where('location_id', $request->location);
        }
        if ($request->has('category') && $request->category) {
            $baseQuery->where('category_id', $request->category);
        }
        if ($request->has('type') && $request->type) {
            $baseQuery->whereIn('type', $request->type);
        }
        if ($request->has('salary') && $request->salary) {
            $baseQuery->where(function ($q) use ($request) {
                foreach ($request->salary as $range) {
                    $range = str_replace('$', '', $range);
                    if (str_contains($range, '-')) {
                        [$min, $max] = explode('-', $range);
                        $q->orWhereBetween('salary', [(int) $min, (int) $max]);
                    } elseif (str_starts_with($range, '+')) {
                        $min = str_replace(['+', '$'], '', $range);
                        $q->orWhere('salary', '>=', (int) $min);
                    }
                }
            });
        }
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $baseQuery->where(function ($q) use ($searchTerm) {
                $q->where('tittle', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('location', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhereHas('category', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        $isPremium = false;
        if (Auth::check()) {
            $user = Auth::user();
            $isPremium = ($user->is_premium || $user->role === 'admin');
        }

        if (!$isPremium) {
            $baseQuery->where('posts.created_at', '<=', now()->subHours(24));
        }

        $query = $baseQuery->join('users', 'posts.user_id', '=', 'users.id')
            ->orderByRaw('CASE WHEN users.is_premium = 1 THEN 0 ELSE 1 END')
            ->select('posts.*');

        // Sorting filter from request
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'title-asc':
                    $query->orderBy('tittle', 'asc');
                    break;
                case 'title-desc':
                    $query->orderBy('tittle', 'desc');
                    break;
                case 'highest-paid':
                    $query->orderBy('salary', 'desc');
                    break;
                case 'lowest-paid':
                    $query->orderBy('salary', 'asc');
                    break;
            }
        } else {
            $query->orderByDesc('posts.created_at'); // Default sort if none selected
        }

        $posts = Post::with(['category', 'location', 'company', 'user'])->fromSub($query, 'posts')->paginate(7);

        $savedPost = SavedPosts::where('user_id', Auth::id())
            ->get(['post_id', 'id'])
            ->map(function ($saved) {
                return [
                    'post_id' => $saved->post_id,
                    'saved_post_id' => $saved->id,
                ];
            });
        return Inertia::render('jobs/Jobs', [
            'categories' => $categories,
            'cities' => $cities,
            'posts' => $posts,
            'savedPost' => $savedPost,
            'isPremium' => $isPremium,
        ]);
    }

    public function create(){
        $cities = City::all();
        $categories = Category::all();
        $kompania = Company::where('user_id', Auth::id())->first();

        if (!$kompania) {
            return redirect()->route('profilePage')->with('error', 'You don`t have a company added');
        }
        if (Auth::user()->role !== 'employer') {
            return redirect()->route('profilePage')->with('error', 'You aren`t registered as an employer');
        }

        return Inertia::render('jobs/CreateJob', [
            'authUser' => Auth::id(),
            'cities' => $cities,
            'categories' => $categories,
            'kompania' => $kompania,
        ]);
    }
    public function store(Request $request){
        $user = Auth::user();
        $companyExists = Company::where('user_id', $user->id)->exists();
        if (!$companyExists) {
            return redirect()->back()->with('error', 'You don`t have a company');
        }
        if ($user->role === 'employee'){
            return redirect()->back()->with('error', 'You are registered as an Employee');
        }
        $request->validate([
            'user_id' => 'required',
            'tittle' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'company_id' => 'required',
            'type' => 'required',
            'salary' => 'required',
            'nrWorkers' => 'required',
            'location_id' => 'required',
            'expiration_date' => 'required',
        ]);

        $job = Post::create([
            'user_id' => $request->user_id,
            'tittle' => $request->tittle,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'company_id' => $request->company_id,
            'type'=> $request->type,
            'salary'=> $request->salary,
            'nrWorkers'=> $request->nrWorkers,
            'location_id'=> $request->location_id,
            'expiration_date'=> $request->expiration_date,
        ]);

        $employer = $job->user_id;
        $message = 'Your post ' . $job->tittle . ' has been created successfully';
        event(new Notifications($message, $employer));

        return redirect(route('jobs.index'))->with('success', 'Job created successfully');
    }

    public function show($id){
        $user = User::with(['city', 'cv'])->where('id', Auth::id())->first();
        $post = Post::with(['category', 'location', 'company' ])->find($id);
        $savedPost = SavedPosts::where('post_id', $id)
            ->where('user_id', Auth::id())
            ->pluck('id')
            ->first();
        return Inertia::render('jobs/ShowJobs', [
            'post' => $post,
            'savedPost' => $savedPost,
            'user' => $user,
        ]);
    }
    public function edit($id)
    {
        $post = Post::with(['category','location', 'company'])->find($id);
        $cities = City::all();
        $categories = Category::all();

        if (Auth::id() !== $post->user_id) {
            return redirect()->route('jobs.index')->with('error', 'You don`t have permission to access this page');
        }

        return Inertia::render('jobs/EditJob', [
            'authUser' => Auth::id(),
            'post' => $post,
            'cities' => $cities,
            'categories' => $categories
        ]);
    }
    public function update(Request $request, $id){
        $post = Post::findOrFail($id);
        $request->validate([
            'tittle' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'salary' => 'required',
            'nrWorkers' => 'required',
            'location_id' => 'required',
            'expiration_date' => 'required',
        ]);
        $post->update($request->except(['user_id', 'company_id']));

        $employer = $post->user_id;
        $message = 'Your post ' . $post->tittle . ' has been updated successfully';
        event(new Notifications($message, $employer));

        return redirect(route('jobs.index'))->with('success', 'Job information updated successfully');
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('jobs.index')->with('error', 'You don`t have permission to access this page');
        }
        $post->delete();
        return Redirect::route('jobs.index')->with('success', 'Job deleted successfully');
    }
    public function storeSaved(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'post_id'=>'required',
        ]);

        $application = SavedPosts::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
        ]);

        return redirect()->back()->with('success', 'Saved Post Successfully');
    }
    public function deleteSaved($id)
    {
        $savedPost = SavedPosts::where('user_id', Auth::id())->find($id);
        if (Auth::id() !== $savedPost->user_id) {
            return redirect()->route('jobs.index')->with('error', 'You don`t have permission to access this page');
        }
        $savedPost->delete();
        return redirect()->back()->with('success', 'Post UnSaved');
    }
}
