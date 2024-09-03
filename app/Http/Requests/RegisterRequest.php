<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ];
    }
}
