<?php

namespace Tests\Feature\Training\Exercise;

use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Exercise\MuscleGroup;
use App\Traits\TestCase\HasModelsJsonStructures;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MuscleGroupTest extends TestCase
{
    use RefreshDatabase, HasModelsJsonStructures;

    public function testReturnMuscleGroups(): void
    {
        MuscleGroup::factory(3)->create();

        $this
            ->getJson(route('training.exercise.muscle-group.all', [
                'paginated' => true,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasPagination()
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(3)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->muscleGroupJsonStructure())
                    )
                )
            );
    }

    public function testDisablePaginationOnListOfMuscleGroups(): void
    {
        MuscleGroup::factory(3)->create();

        $this
            ->getJson(route('training.exercise.muscle-group.all', [
                'paginated' => false,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->count(3)
                ->each(fn(AssertableJson $json) => $json
                    ->whereAllType($this->muscleGroupJsonStructure())
                )
            );
    }
}
