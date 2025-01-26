<?php

namespace App\Listeners\File;

use App\Events\File\FileDeleted;
use Illuminate\Support\Facades\Storage;

class DeleteFileFromServer
{
    public function handle(FileDeleted $event)
    {
        if (Storage::disk('public')->exists($event->file->path)) {
            Storage::disk('public')->delete($event->file->path);
        }
    }
}
