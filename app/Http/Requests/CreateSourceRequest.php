<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSourceRequest extends FormRequest
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
            'name' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'api_token.required' => 'API token required',
            'name.required' => 'Source name required',
            'latitude.required' => 'Latitude required',
            'latitude.numeric' => 'Latitude must be a number',
            'longitude.required' => 'Longitude required',
            'longitude.numeric' => 'Longitude must be a number',
        ];
    }
}
