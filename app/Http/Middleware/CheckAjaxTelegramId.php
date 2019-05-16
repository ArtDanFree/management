<?php

namespace App\Http\Middleware;

use App\Models\Notification;
use Closure;
use Config;
use Telegram\Bot\Api;

class CheckAjaxTelegramId
{
    public function handle($request, Closure $next)
    {
        if ($request->notification_id == '1' and $request->confirmed == true) {
            if ($request->telegram == null) {
                 return response()->json(array('error'=> 'Укажите телеграм ID'), 200);
            }
            $api = new Api(Config::get('constants.telegramBotToken'));
            try {
                $api->getChat([
                    'chat_id' => \Auth::user()->telegram
                ]);
            } catch (\Exception $e) {
                if ($e->getMessage() == 'Bad Request: chat not found') {
                return response()->json(array('error'=>'Добавьте бота ' . Config::get('constants.telegramBot') . ' в контакты.'), 200);
                }
                return response()->json(array('error'=> $e->getMessage()), 200);
            }
        }

        return $next($request);
    }
}
