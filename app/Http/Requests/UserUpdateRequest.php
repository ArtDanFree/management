<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        if (\Gate::allows('lead')) {
            return [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'surname' => 'required|string',
                'organization' => 'required|string',
                'credit_card_number' => 'string|string',
                'personal_acc' => 'required|string',
                'correspondent_acc' => 'required|string',
                'bic_bank' => 'required|string',
                'name_bank' => 'required|string',
            ];
        } else {
            return [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'surname' => 'required|string',
                'telegram' => 'nullable|integer',
            ];
        }
    }

    public function attributes()
    {
        return [
            'first_name' => '"Имя"',
            'last_name' => '"Фамилия"',
            'surname' => '"Отчество"',
            'organization' => '"Организация"',
            'credit_card_number' => '"Номер банковской карты"',
            'personal_acc' => '"Лицевой или расчетный счет"',
            'correspondent_acc' => '"Корр. сч"',
            'bic_bank' => '"БИК банка"',
            'name_bank' => '"Наименование банка"',
        ];
    }
}
