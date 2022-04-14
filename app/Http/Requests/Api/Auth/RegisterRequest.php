<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'             => 'required|min:3|max:32',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:8|max:255',
            'confirm_password' => 'required|same:password',
        ];
    }
}
