<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadStatusUpdateRequest extends FormRequest
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
            'total_amount' => 'integer',
            'comment' => 'nullable|required_if:transaction_status,4|min:10|max:255',
            'rejection_reason' => 'required_if:lead_status,4',
        ];
    }

    public function messages()
    {
        return [
            'rejection_reason.required_if' => 'Укажите причину отказа',
            'comment.required_if' => 'Укажите причину отказа'
        ];
    }

    public function attributes()
    {
        return [
            'total_amount' => '"Сумма"',
            'comment' => '"Комментарий"',
        ];
    }
}
