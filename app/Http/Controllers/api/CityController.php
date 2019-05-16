<?php

namespace App\Http\Controllers\api;

use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCities()
    {
        $cities = City::all('id', 'name');

        return response()->json([
            'cities' => $cities
        ]);
    }

    public function autocomplete(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = City::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }
}