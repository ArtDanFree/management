<?php

namespace App\Http\Controllers;


use App\Jobs\SendLeadStatisticsToTelegram;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Telegram\Bot\Laravel\Facades\Telegram;
use Zend\Diactoros\Uri;

class TestController extends Controller
{

    public function api()
    {
        dispatch(new SendLeadStatisticsToTelegram(123123));
    }
}