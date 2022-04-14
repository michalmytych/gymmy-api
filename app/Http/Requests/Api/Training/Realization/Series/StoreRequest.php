<?php

namespace App\Http\Requests\Api\Training\Realization\Series;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'repetitions_count' => 'required|integer|min:0|max:1000',
            'weight_kg'         => 'required|numeric|min:0|max:1000',
        ];
    }
}
