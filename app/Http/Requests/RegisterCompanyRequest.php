<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCompanyRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'mode' => 'required|exists:modes,name',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Company name required',
            'email.required' => 'Email required',
            'email.email' => 'Email field must be of type email',
            'email.unique' => 'Email already in use',
            'password.required' => 'Password required',
            'mode.required' => 'Mode required',
            'mode.exists' => 'Mode does not exist',
        ];
    }
}
