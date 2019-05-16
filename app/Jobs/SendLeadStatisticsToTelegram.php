<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\User;
use App\Models\UserCity;
use Carbon\Carbon;
use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Telegram\Bot\Api;

class SendLeadStatisticsToTelegram implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $leads;
    protected $howManyIssued;
    protected $citiesInWhichWeWork;
    protected $leadsG;
    protected $weekAgo;
    protected $telegram;


    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->weekAgo = Carbon::now()->subDays(7);
        //Добавленные лиды за последние 7 дней
        $this->leads = Lead::with('underwriter', 'user.payment')->where('created_at', '>=', $this->weekAgo)->get();
        //Лиды которым выдали деньги за последние 7 дней
        $this->howManyIssued = Lead::where('date_of_issue', '>=', $this->weekAgo)->get();
        // города в которых мы работаем
        $this->citiesInWhichWeWork = UserCity::all('city_id')->unique('city_id');
        $this->leadsG = $this->leadsG();
        $this->send();
    }

    public function leadsG()
    {
        $users = User::whereHas('role', function ($q) {
            $q->where('role_id', 3);
        })->get();
        return $users;
    }

    public function send()
    {
        $api = new Api(Config::get('constants.telegramBotToken'));
        $api->sendMessage([
            'chat_id' => $this->telegram,
            'text' => $this->message(),
            'parse_mode' => 'HTML'
        ]);
    }

    public function howMuchIsIssued()
    {// Сколько выдано
        return $this->leads->where('date_of_issue')->count();
    }

    public function howMuchMoney()
    {//на какую общую сумму.
        return $this->leads->where('date_of_issue')->sum('total_amount');
    }

    public function claimed()
    {//Востребовано
        return $this->leads->pluck('city_id')->intersect($this->citiesInWhichWeWork->pluck('city_id'))->count();
    }

    public function notClaimed()
    {//Не востребовано
        return $this->leads->pluck('city_id')->diff($this->citiesInWhichWeWork->pluck('city_id'))->count();
    }

    public function howMuchIsNotClaimed()
    {
        return $this->leads->pluck('city_id', 'money')
            ->diff($this->citiesInWhichWeWork->pluck('city_id'))
            ->transform(function ($item, $key) {
                return $key;
            })
            ->sum();
    }

    public function howMuchIsClaimed()
    {
        return $this->leads->pluck('city_id', 'money')
            ->intersect($this->citiesInWhichWeWork->pluck('city_id'))
            ->transform(function ($item, $key) {
                return $key;
            })
            ->sum();
    }

    public function conversion()
    {//Конверсия за вычетом невостребованных
        return (int)(100 / $this->claimed()) * $this->howMuchIsIssued();
    }

    public function checked()
    {
        return $this->leads->where('approval_date')->count();
    }

    public function leadCommission()
    {//количество денег которое выплатить в виде комиссий за всех одобренных на этой неделе лидов.
        $leads = $this->leads->groupBy('user_id');
        $leads = $leads->map(function ($item) {
            $leads = $item->filter(function ($item) {
                return $item->transaction_status == 3 /*and $item->user->payment == null*/;
            });
            if ($leads->isNotEmpty()) {
                return ($leads->sum('total_amount') / 100) * $leads->first()->user->commission;
            }
        });
        return $leads->sum();
    }

    public function amountOfIssue()
    {//сумма выдачи
        $amountOfIssue = $this->leads->filter(function ($item) {
            return $item->transaction_status == 3 /*and $item->user->payment == null*/;
        })->sum('total_amount');

        return $amountOfIssue;
    }

    public function leadConnected()
    {
        return $this->leadsG->where('created_at', '>=', $this->weekAgo);
    }

    public function countLeadWeekAgo()
    {
        return $this->leadsG->count() - $this->leadConnected()->count();
    }

    public function message()
    {
        $message =
            '<b>' . $this->weekAgo->format('d.m.Y') . '</b> -' . " <b>" . Carbon::now()->format('d.m.Y') . "</b>\n\n" .
            "Добавили " . $this->leads->count() . " лидов \n" .
            "Невостребованных " . $this->notClaimed() . " на " . $this->howMuchIsNotClaimed() . " рублей\n" .
            "Востребованных " . $this->claimed() . " на " . $this->howMuchIsClaimed() . " рублей\n\n" .
            "Проверили " . $this->checked() . " из " . $this->claimed() . " лидов\n" .
            "Выдали " . $this->howMuchIsIssued() . " из " . $this->claimed() . " лидов\n" .
            "Конверсия: " . $this->conversion() . "%\n" .
            "Всего выдали " . $this->howManyIssued->count() . " лидов\n\n" .

            "Сумма выдачи: " . $this->amountOfIssue() . " рублей\n" .
            "Комиссия лидогенераторов: " . $this->leadCommission() . " рублей\n\n" .
            "Лидогенераторов подключилось " . $this->leadConnected()->count() . " в начале недели было " . $this->countLeadWeekAgo() . " всего " . $this->leadsG->count() . "\n";

        return $message;
    }

    public function handle()
    {
    }
}