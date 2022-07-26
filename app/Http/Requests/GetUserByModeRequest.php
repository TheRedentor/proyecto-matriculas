<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetUserByModeRequest extends FormRequest
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
            'mode_id' => 'required|integer|exists:modes,id',
        ];
    }

    public function messages(){
        return [
            'api_token.required' => 'API token required',
            'mode_id.required' => 'Mode required',
            'mode_id.numeric' => 'Mode must be an integer number',
            'mode_id.exists' => 'Mode does not exist',
        ];
    }
}
