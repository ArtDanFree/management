<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadImageStoreRequest extends FormRequest
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
            'lead_id' => 'required|integer',
            'documents' => 'required',
            'documents.*' => 'mimes:pdf,jpeg,png,bmp,gif,svg|max:10000',
        ];
    }
}
