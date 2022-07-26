<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditSourceRequest extends FormRequest
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
            'source_name' => 'required',
        ];
    }

    public function messages(){
        return [
            'api_token.required' => 'API token required',
            'source_name.required' => 'Source name required',
        ];
    }
}