<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAboutNewLeadToMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $subject = 'Добавлен новый лид';

    public function __construct($lead)
    {
        $this->lead = $lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.notify_about_new_lead_to_mail');
    }
}
