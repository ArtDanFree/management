<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

/**
 * Class HelpCommand.
 */
class HelpCommand extends Command
{
    protected $name = 'help';
    protected $description = 'список команд';

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $commands = $this->telegram->getCommands();
        $text = '';
        foreach ($commands as $name => $handler) {
            if ($name == 'start') {
                continue;
            }
            $text .= sprintf('/%s - %s' . PHP_EOL, $name, $handler->getDescription());
        }
        $this->replyWithMessage(compact('text'));
    }
}