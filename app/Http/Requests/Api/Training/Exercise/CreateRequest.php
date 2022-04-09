<?php

namespace App\Http\Requests\Api\Training\Exercise;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                => 'required|max:255',
            'description'         => 'required|max:2096',
            'muscle_groups_ids'   => 'array',
            'muscle_groups_ids.*' => 'exists:muscle_groups,id',
        ];
    }
}
