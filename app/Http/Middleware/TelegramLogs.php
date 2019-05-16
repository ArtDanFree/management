<?php

namespace App\Http\Middleware;

use Closure;
use function Deployer\Support\array_to_string;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class TelegramLogs
{
    public function handle($request, Closure $next)
    {
        $log = new Logger('telegram');
        $log->pushHandler(new StreamHandler(storage_path('/logs/telegram.log'), Logger::INFO));
        $log->info(collect($request->all()));

        return $next($request);
    }
}
