<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'surname' => 'nullable|string',
            'money' => 'nullable|integer',
            'phone' => 'required|string',
            'city_id' => 'required',
            'collateral' => 'required|between:1,2'
        ];
    }
    public function attributes()
    {
        return [
            'first_name' => '"Имя"',
            'last_name' => '"Фамилия"',
            'surname' => '"Отчество"',
            'money' => '"Желаемая сумма"',
            'phone' => '"Телефон"',
            'city_id' => '"Город"',
            'collateral' => '"Тип залога"'
        ];
    }

}
