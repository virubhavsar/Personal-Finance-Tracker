<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Implement authorization logic if needed
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'role' => 'required|in:Admin,User',
        ];
    }
}
