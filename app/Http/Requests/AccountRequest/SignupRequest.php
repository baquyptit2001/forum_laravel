<?php

namespace App\Http\Requests\AccountRequest;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            '*.username' => 'required|between:6,16|unique:users,username|bail',
            '*.email' => 'required|email|unique:users,email|bail',
            '*.password' => 'required|between:6,16|bail'
        ];
    }

    public function messages()
    {
        return [
            '*.email.required' => config('constants.EMAIL_REQUIRED'),
            '*.email.email' => config('constants.EMAIL_VALIDATE'),
            '*.email.unique' => config('constants.EMAIL_UNIQUE'),
            '*.username.required' => config('constants.USER_REQUIRED'),
            '*.username.between' => config('constants.USER_BETWEEN'),
            '*.username.unique' => config('constants.USER_UNIQUE'),
            '*.password.required' => config('constants.PASSWORD_REQUIRED'),
            '*.password.between' => config('constants.PASSWORD_BETWEEN'),
        ];
    }
}
