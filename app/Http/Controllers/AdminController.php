<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $EmployeeCount = User::where('role' , 'employee')->count();
        $EmployerCount = User::where('role' , 'employer')->count();
        $PostCount = Post::all()->count();
        $ApplicationCount = Application::all()->count();
        $Users = User::with('city')->get();
        $Posts = Post::with('user','company')->get();
        $accepted = Application::where('status' , 'accepted')->count();
        $rejected = Application::where('status' , 'rejected')->count();

        return Inertia::render('Dashboard', [
            'EmployeeCount' => $EmployeeCount,
            'EmployerCount' => $EmployerCount,
            'PostCount' => $PostCount,
            'ApplicationCount' => $ApplicationCount,
            'Users' => $Users,
            'Posts' => $Posts,
            'accepted' => $accepted,
            'rejected' => $rejected,
        ]);
    }

    public function deleteUser(User $user){

        $user->delete();
        return Redirect::back()->with('success', 'User has been deleted');

    }

    public function deletePost(Post $post){
        $post->delete();
        return Redirect::back()->with('success', 'Post has been deleted');
    }


}
