<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;

class StatisticController extends Controller
{
    protected $statistic;
    protected $user;
    protected $leads;
    protected $issuedLeads;

    public function __construct($user = null)
    {
        if ($user == null) {
            $this->user = auth()->user();
        } else {
            $this->user = User::find($user);
        }
    }

    public function leadGenerator()
    {
        $this->leads = Lead::where('user_id', $this->user->id)->where('created_at', 'like', date('Y-m') . '%')->get();
        $this->issuedLeads = $this->issuedLeads();

        return [
            'date' => $this->date(),
            'earned' => $this->earned(),
            'issued' => $this->issuedApplications(),
            'count' => $this->count() . ' ' . $this->countText(),
            'on_check' => $this->onCheck() . ' ' . $this->onCheckText(),
            'conversion' => $this->conversion(),
            'bad_quality' => $this->badQuality(),
            'countText' => $this->countText(),
        ];
    }

    public function leadGeneratorMonthly($id)
    {
        $months = Lead::monthly($id);

        $statistic = [];

        foreach ($months as $month => $leads) {
            $this->leads = $leads;
            $this->issuedLeads = $this->issuedLeads();
            $statistic[$month] = [
                'earned' => $this->earned(),
                'issued' => $this->issuedApplications(),
                'count' => $this->count() . ' ' . $this->countText(),
                'on_check' => $this->onCheck() . ' ' . $this->onCheckText(),
                'conversion' => $this->conversion(),
            ];
        }

        return $statistic;
    }

    public function admin()
    {
        $this->leads = Lead::with('user')->where('created_at', 'like', date('Y-m') . '%')->get();

        return [
            'date' => $this->date(),
            'to_pay' => $this->toPay(),
            'issued' => $this->issued(),
            'count' => $this->count() . ' ' . $this->countText(),
            'conversion' => $this->conversion(),
            'on_check' => $this->onCheck() . ' ' . $this->onCheckText(),
            'bad_quality' => $this->badQuality(),
        ];
    }

    protected function issuedLeads()
    {
        return $this->leads->where('transaction_status', 3)->where('lead_status', 3);
    }

    protected function earned()
    {
        return (int)(($this->issuedLeads->sum('money') / 100) * $this->user->commission);
    }

    protected function issuedApplications()
    {
        return $this->leads->where('transaction_status', 3)->where('lead_status', 3)->count();
    }

    protected function count()
    {
        return $this->leads->count();
    }

    protected function onCheck()
    {
        return $this->leads->where('lead_status', 2)->count();
    }

    protected function badQuality()
    {
        return $this->leads->where('lead_status', 4)->count();
    }

    protected function conversion()
    {
        if (!empty($this->issuedApplications() and $this->count())) {
            return (int)($this->issuedApplications() / $this->count() * 100);
        } else {
            return 0;
        }
    }

    protected function toPay()
    {
        return (int)$this->leads->where('transaction_status', 3)->sum('commissionSum');
    }

    protected function issued()
    {
        return $this->leads->where('transaction_status', 3)->where('lead_status', 3)->count();
    }

    protected function countText()
    {
        return $this->sklonen($this->count(), 'заявки', 'заявок', 'заявок');
    }

    protected function onCheckText()
    {
        return $this->sklonen($this->onCheck(), 'заявка', 'заявки', 'заявок');
    }

    protected function sklonen($n, $s1, $s2, $s3, $b = false)
    {
        $m = $n % 10;
        $j = $n % 100;
        if ($b) $n = '<b>' . $n . '</b>';
        if ($m == 0 || $m >= 5 || ($j >= 10 && $j <= 20)) return $s3;
        if ($m >= 2 && $m <= 4) return $s2;
        return $s1;
    }

    protected function date()
    {
        $month = '';
        switch (Carbon::now()->formatLocalized('%m')) {
            case '01':
                $month = "Январь";
                break;
            case '02':
                $month = "Февраль";
                break;
            case '03':
                $month = "Март";
                break;
            case '04':
                $month = "Апрель";
                break;
            case '05':
                $month = "Май";
                break;
            case '06':
                $month = "Июнь";
                break;
            case '07':
                $month = "Июль";
                break;
            case '08':
                $month = "Август";
                break;
            case '09':
                $month = "Сентябрь";
                break;
            case '10':
                $month = "Октябрь";
                break;
            case '11':
                $month = "Ноябрь";
                break;
            case '12':
                $month = "Декабрь";
                break;
        }
        return $month . ' ' . (Carbon::now()->formatLocalized('%Y'));
    }

}
