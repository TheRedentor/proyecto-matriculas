<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteModeRequest extends FormRequest
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
            'name' => 'required|exists:modes',
        ];
    }

    public function messages(){
        return [
            'api_token.required' => 'API token required',
            'name.required' => 'Mode name required',
            'name.exists' => 'Mode does not exist',
        ];
    }
}
