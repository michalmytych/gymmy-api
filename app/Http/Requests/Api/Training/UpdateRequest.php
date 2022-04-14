<?php

namespace App\Http\Requests\Api\Training;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'            => 'required_without_all:description,exercises_ids|max:255',
            'description'     => 'required_without_all:name,exercises_ids|max:2096',
            'exercises_ids'   => 'required_without_all:name,description|array',
            'exercises_ids.*' => 'exists:exercises,id',
        ];
    }
}
