<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ApiController extends Controller
{
    public function __invoke()
    {
        if (Gate::allows('api')) {
            return view('inside.api');
        } else {
            return Redirect::route('home')->withErrors('api могут пользоваться только лиды');
        }
    }
}
