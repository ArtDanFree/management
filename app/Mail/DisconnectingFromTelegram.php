<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DisconnectingFromTelegram extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $reason;

    public function __construct($code, $user)
    {
        $this->user = $user;
        $this->reason($code);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.disconnecting_from_telegram');
    }

    public function reason($code)
    {
        switch ($code) {
            case 400:
                $this->reason = 'Указан не верный Telegram id';
                break;
            case 403:
                $this->reason = 'Бот был вами заблокирован';
                break;
        }
    }
}
