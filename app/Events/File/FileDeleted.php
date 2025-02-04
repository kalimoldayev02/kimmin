<?php

namespace App\Events\File;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $filePaths)
    {
    }
}
