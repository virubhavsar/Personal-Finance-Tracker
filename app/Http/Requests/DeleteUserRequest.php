<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Implement authorization logic if needed
    }

    public function rules()
    {
        return [
            // Add any additional validation rules if necessary
        ];
    }
}
