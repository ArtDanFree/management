<?php

namespace App\Providers;

use App\Helpers\Telegram;
use App\Http\ViewComposers\StatisticComposer;
use App\Models\Lead;
use App\Models\User;
use App\Models\Notification;
use App\Observers\LeadCreatedNotification;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
/*        Lead::observe(LeadCreatedNotification::class);

        setlocale(LC_TIME, 'ru_RU.UTF-8');
        Carbon::setLocale(config('app.locale'));
        View::composer('layouts.inside', StatisticComposer::class);

        User::created(function (User $user) {
            $notification = Notification::all('id', 'name');
            foreach ($notification as $item) {
                $conf = ($item->name == 'Email') ? 1 : 0;
                $user->notification()->attach($item->id,[
                    'confirmed' => $conf
                ]);
            }
        });*/
    }

    public function register()
    {
        //
    }
}
