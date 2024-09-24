<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ResetLoginStreaks extends Command
{
    protected $signature = 'streak:reset';
    protected $description = 'Reset login streaks for users who haven\'t logged in today';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            if (!$user->logged_today) {
                $user->login_streak = 0;
            } else {
                $user->logged_today = false;
            }

            $user->save();
        }

        $this->info('Login streaks reset for users who haven\'t logged in today.');
    }
}
