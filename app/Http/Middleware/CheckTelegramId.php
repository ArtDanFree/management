<?php

namespace App\Http\Middleware;

use App\Models\Notification;
use Closure;
use Config;
use Telegram\Bot\Api;

class CheckTelegramId
{
    public function handle($request, Closure $next)
    {
        $notification = Notification::find($request->notification_id);
        if ($notification->name = 'Telegram' and $request->confirmed == true) {
            if (\Auth::user()->telegram == null) {
                return back()->withErrors('Укажите telegram id');
            }
            $api = new Api(Config::get('constants.telegramBotToken'));
            try {
                $api->getChat([
                    'chat_id' => \Auth::user()->telegram
                ]);
            } catch (\Exception $e) {
                if ($e->getMessage() == 'Bad Request: chat not found') {
                    return back()->withErrors('Добавьте бота ' . Config::get('constants.telegramBot') . ' в контакты.');
                }
                return back()->withErrors($e->getMessage());
            }
        }

        return $next($request);
    }
}
