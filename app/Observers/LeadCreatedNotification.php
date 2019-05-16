<?php

namespace App\Observers;

use App\Mail\DisconnectingFromTelegram;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;

class LeadCreatedNotification
{
    protected $lead;
    public function created(Lead $lead)
    {
        $this->lead = $lead;
        $users = $this->getUsers();
        $this->sendNotification($users);
    }

    public function getUsers()
    {
        $users = User::with('notification', 'fine')->whereHas('city', function ($query) {
             $query->where('city_id', $this->lead->city_id);
        })->whereHas('notification', function ($query) {
            $query->where('confirmed', true);
        })->get();


        return $users;
    }

    public function sendNotification($users)
    {
        foreach ($users as $user) {
            $minutes = $user->fine ? Carbon::now()->addMinutes($user->fine->level) : Carbon::now();
            foreach ($user->notification as $notification) {
                if ($notification->name == 'Telegram' and $notification->pivot->confirmed == true) {
                    try {
                        dispatch(new \App\Jobs\SendTelegramMessage($user->telegram, $this->lead))->delay($minutes);
                    } catch (\Exception $exception) {
                        $this->exceptionHandling($exception, $user->telegram);
                    }
                }
                if ($notification->name == 'Email' and $notification->pivot->confirmed == true) {
                    \Mail::to($user)->later($minutes, new \App\Mail\NotifyAboutNewLeadToMail($this->lead));
                }
            }
        }
    }

    public function exceptionHandling(\Exception $exception, $telegram)
    {
        $user = User::where('telegram', $telegram)->first();
        $t = $user->notification->where('name', 'Telegram')->first();
        $t->pivot->confirmed = 0;
        $t->pivot->save();
        $user->telegram = null;
        $user->save();
        \Mail::to($user)->send(new DisconnectingFromTelegram($exception->getCode(), $user));
    }

}
