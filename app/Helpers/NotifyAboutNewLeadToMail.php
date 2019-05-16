<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 28.08.18
 * Time: 18:30
 */

namespace App\Helpers;


use App\Models\Notification;

class NotifyAboutNewLeadToMail
{
    protected $lead;

    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    public  function send()
    {
        $email = Notification::where('name', 'Email')->first();

        $help = new Helper();
        $users = $help->findPeopleWorkingInTheCity($this->lead->city->id, $email->id);

        if (!empty($users)) {
            \Mail::to($users)->queue(new \App\Mail\NotifyAboutNewLeadToMail($this->lead));
        }

    }
}