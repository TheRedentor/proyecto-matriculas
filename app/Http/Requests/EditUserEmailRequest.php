<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserEmailRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
        ];
    }

    public function messages(){
        return [
            'api_token.required' => 'API token required',
            'api_token.exists' => 'User does not exist',
            'email.required' => 'List name required',
            'email.email' => 'Email field must by of type email',
            'email.unique' => 'Email already in use',
        ];
    }
}
