<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class TelegramConnected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::find(\Auth::id());
        $t = $user->notification->where('name', 'Telegram')->first();

        if (empty(\Auth::user()->telegram)) {
            return response()->json(['message' => 'Укажите Telegram id'], 422);
        }
        if ($t->pivot->confirmed == false) {
            return response()->json(['message' => 'Включите получение уведомлений в Telegram'], 422);
        }

        return $next($request);
    }
}
