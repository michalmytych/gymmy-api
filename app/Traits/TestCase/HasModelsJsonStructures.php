<?php

namespace App\Traits\TestCase;

trait HasModelsJsonStructures
{
    private function trainingJsonStructure(array $appends = []): array
    {
        return $appends + [
                'id'          => 'string',
                'name'        => 'string',
                'user_id'     => 'integer',
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
                'user_id'          => 'integer',
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

    private function realizationJsonStructure(): array
    {
        return [
            'id'                    => 'string',
            'user_id'               => 'integer',
            'parent_realization_id' => ['string', 'null'],
            'realizationable_type'  => 'string',
            'realizationable_id'    => 'string',
            'time_started'          => 'string',
            'time_ended'            => ['string', 'null'],
            'status'                => 'integer',
            'created_at'            => 'string',
            'updated_at'            => 'string',
        ];
    }
}