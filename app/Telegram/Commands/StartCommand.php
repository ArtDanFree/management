<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected $name = "start";
    protected $description = "Добавляет бота в контакты.";

    public function handle()
    {
        $this->replyWithMessage(['text' => 'Здравствуйте! Вот наши доступные команды:']);
        $this->triggerCommand('help');
    }
}