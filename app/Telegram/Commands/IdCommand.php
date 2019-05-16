<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class IdCommand extends Command
{
    protected $name = "id";
    protected $description = "узнать свой id";

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $telegramUser = Telegram::getWebhookUpdates()['message'];
        $message = 'Ваш id: ' . $telegramUser['from']['id'];
        $this->replyWithMessage(['text' => $message]);
    }
}