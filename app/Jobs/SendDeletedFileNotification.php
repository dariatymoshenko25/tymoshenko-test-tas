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
        $context = [
            'fileName' => $this->fileName,
            'emailTo'  => $this->emailTo,
        ];

        // Добавляем ID и попытки, только если джоб запущен через воркера
        if ($this->job) {
            $context['job_id'] = $this->job->getJobId();
            $context['attempts'] = $this->attempts();
        } else {
            $context['warning'] = 'Job executed synchronously (no queue worker context)';
        }
        //sending emails
        \Log::info("Processing: {$this->fileName}", $context);

        \Log::info("Email notification sent: {$this->fileName} → {$this->emailTo}");
    }
}
