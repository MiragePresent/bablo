<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'first_name'    => 'max:255',
            'last_name'     => 'max:255',
            'login'         => 'required|unique:users,login|max:255',
            'email'         => 'required|email|unique:users,email|max:255',
            'password'      => 'required|min:8|max:255'
        ];
    }
}
