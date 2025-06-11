<?php

namespace App\Jobs;

use App\Mail\ReportDismissedMail;
use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReportDismissedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public Report  $report;
    /**
     * Create a new job instance.
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->report->user->email)->send(new ReportDismissedMail($this->report));
    }
}
