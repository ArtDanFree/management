<?php

namespace App\Http\ViewComposers;

use App\Http\Controllers\StatisticController;
use App\Models\City;
use Illuminate\View\View;
use App\Models\User;


class StatisticComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */

    protected $data;
    protected $statistic = [];
    protected $cities;
    protected $notification_user;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository $users
     * @return void
     */


    public function __construct()
    {
        if (\Gate::allows('add-lead')) {
            $this->cities = City::all();
        }

        $user = User::with('notification', 'role')->where('id', \Request::user()->id)->get();
        $this->notification_user = $user;

        $statistic = new StatisticController();
        if (\Gate::allows('lead')) {
            $this->statistic = $statistic->leadGenerator();
        } elseif (\Gate::allows('admin')) {
            $this->statistic = $statistic->admin();
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose()
    {
        \View::share([
            'date' => $this->data,
            'statistic' => $this->statistic,
            'cities' => $this->cities,
            'notification_user' =>$this->notification_user
        ]);
    }
}
