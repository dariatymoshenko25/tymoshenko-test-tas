<?php

namespace App\Services;

use App\Jobs\SendDeletedFileNotification;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function store(UploadedFile $file): File
    {
        $path = $file->store('uploads', 'public');

        return File::create([
            'original_name' => $file->getClientOriginalName(),
            'path'          => $path,
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
            'expires_at'    => now()->addHours(24),
        ]);
    }

    public function delete(File $file): void
    {
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        SendDeletedFileNotification::dispatch(
            $file->original_name,
            config('files.email_to_send_notification')
        );
    }

    public function deleteExpired(): void
    {
        $expired = File::where('expires_at', '<=', now())->get();
        $expired->each(fn(File $f) => $this->delete($f));
    }
}
