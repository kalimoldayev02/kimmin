<?php

namespace App\Providers;

use App\Events\File\FileDeleted;
use App\Listeners\File\DeleteFileFromServer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Event::listen(FileDeleted::class, DeleteFileFromServer::class);
    }
}
