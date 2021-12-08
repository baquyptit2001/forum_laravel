<?php

namespace App\Http\Requests\AccountRequest;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
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
            '*.username' => 'required|between:6,16|bail',
            '*.password' => 'required|between:6,16|bail'
        ];
    }

    public function messages()
    {
        return [
            '*.username.required' => config('constants.USER_REQUIRED'),
            '*.username.between' => config('constants.USER_BETWEEN'),
            '*.password.required' => config('constants.PASSWORD_REQUIRED'),
            '*.password.between' => config('constants.PASSWORD_BETWEEN'),
        ];
    }
}
