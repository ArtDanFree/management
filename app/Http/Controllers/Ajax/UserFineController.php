<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Fine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserFineController extends Controller
{
    public function update(Request $request, $id)
    {
        return Fine::updateOrCreate(['user_id'=> $id], $request->all());
    }
}
