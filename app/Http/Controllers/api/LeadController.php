<?php

namespace App\Http\Controllers\api;

use App\Models\City;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class LeadController extends Controller
{

    public function addLead(Request $request)
    {

        if ($request->city) {
            $cityId = $this->findCity($request->city);

            if (!$cityId) {
                return response()->json([
                    'message' => 'Город не найден.',
                ]);
            }

            $request->merge(['city_id' => $cityId, 'city' => null]);

            return $this->store($request);

        } elseif ($request->city_id) {
            return $this->store($request);
        }
    }


    public function store($request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        Lead::create([
            'phone' => $request->phone,
            'city_id' => $request->city_id,
            'type' => $request->collateral,
            'user_id' => \Request::user()->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'surname' => $request->surname,
            'money' => $request->money,
        ]);

        return response()->json([
            'message' => 'Успешно добавлен',
        ]);
    }

//TODO убрать в request
    private function validator($request)
    {
        $massage = [
            'collateral.required' => 'Поле Тип залога обязательно для заполнения.',
            'collateral.in' => '1 недвижимость, 2 автомобиль'
        ];
        return Validator::make($request, [
            'phone' => 'required',
            'city_id' => 'required',
            'collateral' => 'required|in:1,2',
            'first_name' => 'nullable:',
            'last_name' => 'nullable',
            'surname' => 'nullable',
            'money' => 'nullable',
        ], $massage);
    }

    public function findCity($city)
    {

        $id = City::where('name', $city)->select('id')->first();

        if ($id) return $id->id;
        else return false;

    }
}