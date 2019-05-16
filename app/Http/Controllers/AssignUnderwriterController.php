<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class AssignUnderwriterController extends Controller
{
    public function worksInTheCity($city)
    {
        $underwriters = User::whereHas('role', function ($q) {
            $q->where('name', 'Частный инвестор');
        })
            ->whereHas('city', function ($q) use ($city) {
                $q->where('name', $city);
            })
            ->select(['id', 'first_name', 'last_name', 'surname'])
            ->get();
        return response()->json($underwriters);
    }

    public function all()
    {
        $underwriters = User::whereHas('role', function ($q) {
            $q->where('name', 'Частный инвестор');
        })
            ->select(['id', 'first_name', 'last_name', 'surname'])
            ->get();
        return response()->json($underwriters);
    }

    public function assign(Request $request, $id)
    {
        Lead::find($id)->update($request->all());
    }
}
