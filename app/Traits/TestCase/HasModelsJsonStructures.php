<?php

namespace App\Traits\TestCase;

trait HasModelsJsonStructures
{
    private function trainingJsonStructure(array $appends = []): array
    {
        return $appends + [
                'id'          => 'string',
                'name'        => 'string',
                'description' => 'string',
                'created_at'  => 'string',
                'updated_at'  => 'string',
            ];
    }

    private function exerciseJsonStructure(array $appends = []): array
    {
        return $appends + [
                'id'               => 'string',
                'break_duration_s' => 'integer',
                'description'      => ['string', 'null'],
                'name'             => 'string',
                'created_at'       => 'string',
                'updated_at'       => 'string',
            ];
    }

    private function muscleGroupJsonStructure(array $appends = []): array
    {
        return $appends + [
                'id'          => 'string',
                'name'        => 'string',
                'description' => ['string', 'null'],
                'created_at'  => 'string',
                'updated_at'  => 'string',
            ];
    }
}