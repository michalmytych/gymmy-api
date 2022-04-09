<?php

namespace App\Http\Requests\Api\Training\Exercise;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                => 'required_without_all:description,muscle_groups_ids|max:255',
            'description'         => 'required_without_all:name,muscle_groups_ids|max:2096',
            'muscle_groups_ids'   => 'required_without_all:name,description|array',
            'muscle_groups_ids.*' => 'exists:muscle_groups,id',
        ];
    }
}
