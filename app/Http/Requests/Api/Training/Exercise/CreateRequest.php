<?php

namespace App\Http\Requests\Api\Training\Exercise;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                => 'max:255',
            'description'         => 'max:2096',
            'muscle_groups_ids'   => 'array',
            'muscle_groups_ids.*' => 'exists:muscle_groups,id',
        ];
    }
}
