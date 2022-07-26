<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateModeRequest extends FormRequest
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
            'name' => 'required|unique:modes',
            'cache' => 'required|boolean',
            'sources' => 'required|boolean'
        ];
    }

    public function messages(){
        return [
            'api_token.required' => 'API token required',
            'name.required' => 'Mode name required',
            'name.unique' => 'Mode name already exists',
            'cache.required' => 'Cache required',
            'cache.boolean' => 'Cache must be a boolean',
            'sources.required' => 'Sources required',
            'sources.boolean' => 'Sources must be a boolean',
        ];
    }
}
