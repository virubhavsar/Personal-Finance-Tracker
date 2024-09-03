<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToggleActiveStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can implement authorization logic here
    }

    public function rules()
    {
        return [
            'is_active' => 'required|boolean',
        ];
    }
}
