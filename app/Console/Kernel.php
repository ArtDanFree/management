<?php

namespace App\Console;

use App\Jobs\SendLeadStatisticsToTelegram;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        //
    ];
    protected $users;

/*    protected function schedule(Schedule $schedule)
    {
        $this->users = User::whereHas('role', function ($q) {
            $q->where('name', 'Администратор');
        })
            ->whereNotNull('telegram')
            ->whereHas('notification', function ($query) {
                $query->where('confirmed', true)->where('notification_id', 1);
            })->get();
        if ($this->users->isNotEmpty()):
            $schedule->call(function () {
                foreach ($this->users as $user):
                    dispatch((new SendLeadStatisticsToTelegram($user->telegram))->delay(5));
                endforeach;
            })->weekly()->mondays()->at('10:00');
        endif;
    }*/

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
