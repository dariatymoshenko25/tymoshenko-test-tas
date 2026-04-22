<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDeletedFileNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fileName;
    public $emailTo;
    public $deletedAt;

    /**
     * Create a new job instance.
     */
    public function __construct(string $fileName, string $emailTo)
    {
        $this->fileName = $fileName;
        $this->emailTo = $emailTo;
        $this->deletedAt = now();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //sending emails

        \Log::info("Email notification sent: {$this->fileName} → {$this->emailTo}");
    }
}
