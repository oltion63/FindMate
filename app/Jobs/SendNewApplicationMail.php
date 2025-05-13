<?php

namespace App\Jobs;

use App\Mail\NewApplication;
use App\Models\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use function Laravel\Prompts\search;

class SendNewApplicationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public Application $application;
    /**
     * Create a new job instance.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->application->post->user->email)->send(new NewApplication($this->application));
    }
}
