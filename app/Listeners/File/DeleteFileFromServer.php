<?php

namespace App\Listeners\File;

use App\Events\File\FileDeleted;
use Illuminate\Support\Facades\Storage;

class DeleteFileFromServer
{
    public function handle(FileDeleted $event)
    {
        foreach ($event->filePaths as $filePath) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
