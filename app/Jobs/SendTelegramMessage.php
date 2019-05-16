<?php

namespace App\Jobs;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lead;
    public $telegram;

    public function __construct($telegram, Lead $lead)
    {
        $this->telegram = $telegram;
        $this->lead = $lead;
    }

    public function handle()
    {
        $t = Telegram::sendMessage([
            'chat_id' => $this->telegram,
            'text' => $this->generateMessage(),
            'parse_mode' => 'HTML'
        ]);

        $this->addLog($t);
    }

    public function generateMessage()
    {
        $message = "Добавлен новый лид \n" .
            "\n Город: " . $this->lead->city->name . ".\n" .
            "\n Тип залога: " . $this->lead->typeDeposit->name . ".\n" .
            "\n Сумма: " . $this->lead->money . " руб.\n" .
            "\n".'<a href="'.Route('home', ['lead_id' => $this->lead->id]) .'">Взять на проверку</a>';
        return $message;
    }

    public function addLog($t)
    {
        $log = new Logger('sendTelegramMessage');
        $log->pushHandler(new StreamHandler(storage_path('/logs/sendTelegramMessage.log'), Logger::NOTICE));

        $log->notice($t->chat);
    }
}
