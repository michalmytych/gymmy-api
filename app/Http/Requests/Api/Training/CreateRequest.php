<?php

namespace App\Http\Requests\Api\Training;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'            => 'required|max:255',
            'description'     => 'required|max:2096',
            'exercises_ids'   => 'array',
            'exercises_ids.*' => 'exists:exercises,id',
        ];
    }
}
