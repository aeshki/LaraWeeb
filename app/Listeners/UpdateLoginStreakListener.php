<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;

class UpdateLoginStreakListener
{
    public function handle(Authenticated $event)
    {
        $user = $event->user;

        if (!$user->logged_today) {
            $user->logged_today = true;
            $user->login_streak += 1;
            $user->save();
        }
    }
}