<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Jobs\SendAcceptedMail;
use App\Jobs\SendAppliedMail;
use App\Jobs\SendNewApplicationMail;
use App\Jobs\SendRejectedMail;
use App\Mail\NewApplication;
use App\Models\Application;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        if ($user->role === 'employer' ) {
            return redirect()->back()->with('error', 'You are registered as a employer');
        }
        $post = Post::with('user')->findOrFail($request->post_id);
        if ($post->nrWorkers === 0) {
            return redirect()->back()->with('error', 'no free slots available' );
        }
        $exists = Application::where('user_id', $request->user_id)
            ->where('post_id', $request->post_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with(['error' => 'You have already applied for this job.']);
        }
        if (!$user->cv) {
            return redirect()->back()->with(['error' => 'You must upload a CV before applying.']);
        }
        $request->validate([
            'user_id'=>'required',
            'post_id'=>'required',
        ]);
        $application = Application::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'status' => 'pending',
        ]);
        $post->decrement('nrWorkers');
        $employer = $post->user_id;
        $message = 'You have a new application for '.$post->tittle . ' from ' . auth()->user()->name;
        event(new Notifications($message, $employer));

        $applicant = $application->user_id;
        $message = 'You successfully applied for ' . $post->tittle;
        event(new Notifications($message, $applicant));


        SendNewApplicationMail::dispatch($application)->onQueue('queue');
        SendAppliedMail::dispatch($application)->onQueue('queue');
        return redirect(route('jobs.index'))->with('success', 'You have successfully applied for this job');
    }

    public function delete($id)
    {
        $application = Application::findOrFail($id);
        $owner = auth()->id();
        if ($owner !== $application->user_id) {
            return redirect()->back()->with('error', 'You are not allowed to delete this job');
        }
        $post = $application->post;
        $application->delete();
        $post->increment('nrWorkers');

        $employer = $post->user_id;
        $message = $employer . ' has canceled application for ' . $post->tittle;
        event(new Notifications($message, $employer));

        return redirect()->back()->with('success', 'Application has been deleted');
    }

    public function accept($id){
        $application = Application::findOrFail($id);
        if ($application->status === 'pending' || $application->status === 'rejected') {
            $application->update(['status' => 'accepted']);
        }
        SendAcceptedMail::dispatch($application)->onQueue('queue');
        $post = $application->post;
        $applicant = $application->user->id;
        $message = 'Your application for '.$post->tittle . ' has been accepted';
        event(new Notifications($message, $applicant));

        return redirect()->back()->with('success', 'Application accepted');
    }
    public function reject($id){
        $application = Application::findOrFail($id);
        if ($application->status === 'pending' || $application->status === 'accepted') {
            $application->update(['status' => 'rejected']);
        }
        $post = $application->post;
        $applicant = $application->user->id;
        $message = 'Your application for '.$post->tittle . ' has been rejected';
        event(new Notifications($message, $applicant));
        SendRejectedMail::dispatch($application)->onQueue('queue');
        return redirect()->back()->with('success', 'Application rejected');
    }
}
