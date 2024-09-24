<?php

namespace App\Providers;

use App\Listeners\UpdateLoginStreakListener;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(Authenticated::class, UpdateLoginStreakListener::class);
    }
}
