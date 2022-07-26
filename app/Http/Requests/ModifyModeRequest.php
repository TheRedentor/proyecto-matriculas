<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifyModeRequest extends FormRequest
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
            'api_token' => 'required',
            'mode' => 'required|exists:modes,name',
        ];
    }

    public function messages(){
        return [
            'api_token.required' => 'API token required',
            'mode.required' => 'Mode required',
            'mode.exists' => 'Mode does not exist',
        ];
    }
}
