<?php

namespace App\Http\Middleware;

use App\Models\Lead;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Request;

class TakeLeadToCheck
{
    public $min;
    public $user;
    public $lead;


    public function handle($request, Closure $next)
    {
        $this->user = \Auth::user();
        $this->lead = Lead::find($request->lead_id);
        if (\Gate::denies('underwriter'))
            return response()->json(['message' => 'Oops!']);

        if (!$this->ifFine())
            return response()->json(['message' => 'Лида можно будет взять через ' . $this->min]);

        if ($this->lead->underwriter != null)
            return response()->json(['message' => 'Этого лида уже взяли на проверку']);

        if (!$this->workInCity()) {
            return response()->json(['message' => 'Вы не работаете в этом городе']);
        }
        return $next($request);
    }

    public function workInCity()
    {
        $city = $this->user->city->first(function ($value, $key) {
            return $value->name == $this->lead->city->name;
        });
        return !empty($city);
    }

    public function ifFine()
    {
        $level = $this->user->fine ? $this->user->fine->level : 0;
        if ($this->lead->created_at->addMinute($level) > Carbon::now()) {
            $this->min = $this->lead->created_at->addMinute($level)->diffForHumans(Carbon::now(), true);
            return false;
        }
        return true;
    }
}
