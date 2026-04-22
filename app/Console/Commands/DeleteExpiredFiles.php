<?php

namespace App\Console\Commands;

use App\Services\FileService;
use Illuminate\Console\Command;

class DeleteExpiredFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes expired files and sends notifications to RabbitMQ';

    /**
     * Execute the console command.
     */
    public function handle(FileService $fileService) : int
    {
        try {
            $fileService->deleteExpired();
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error while deleting: {$e->getMessage()}");
            return self::FAILURE;
        }
    }
}
