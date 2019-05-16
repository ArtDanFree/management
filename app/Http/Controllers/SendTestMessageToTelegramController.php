<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendTestMessageToTelegramController extends Controller
{
    public function __invoke(Request $request)
    {
        Telegram::sendMessage([
            'chat_id' => \Auth::user()->telegram,
            'text' => 'Тестовое сообщение',
        ]);
        return response()->json(['message' => 'Сообщение успешно отправлено']);
    }
}
