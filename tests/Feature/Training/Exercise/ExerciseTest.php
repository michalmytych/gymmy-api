<?php

namespace Tests\Feature\Training\Exercise;

use Tests\TestCase;
use App\Models\Training\Training;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Exercise\MuscleGroup;
use App\Traits\TestCase\HasModelsJsonStructures;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExerciseTest extends TestCase
{
    use RefreshDatabase, HasModelsJsonStructures;

    public function testReturnPaginatedListOfExercises(): void
    {
        Exercise::factory(3)->create();

        $this
            ->getJson(route('training.exercise.all', [
                'paginated' => true,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasPagination()
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(3)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->exerciseJsonStructure())
                    )
                )
            );
    }

    public function testDisablePaginationOnListOfExercises(): void
    {
        Exercise::factory(3)->create();

        $this
            ->getJson(route('training.exercise.all', [
                'paginated' => false,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->count(3)
                ->each(fn(AssertableJson $json) => $json
                    ->whereAllType($this->exerciseJsonStructure())
                )
            );
    }

    public function testFindExerciseById(): void
    {
        $exercise = Exercise::factory(3)
            ->create()
            ->first();

        $this
            ->getJson(route('training.exercise.find', $exercise))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('id', $exercise->id)
                ->whereAllType($this->exerciseJsonStructure())
            );
    }

    public function testCreateExercise(): void
    {
        $this
            ->postJson(route('training.exercise.create'), [
                'name'              => '::name::',
                'description'       => '::description::',
                'break_duration_s'  => 90,
                'muscle_groups_ids' => MuscleGroup::factory(3)->create()->pluck('id'),
            ])
            ->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('name', '::name::')
                ->where('description', '::description::')
                ->whereAllType($this->exerciseJsonStructure(appends: [
                    'muscle_groups' => 'array',
                ]))
                ->has('muscle_groups', fn(AssertableJson $json) => $json
                    ->count(3)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->muscleGroupJsonStructure(appends: [
                            'pivot' => 'array',
                        ]))
                    )
                )
            );
    }

    public function testUpdateExercise(): void
    {
        $exercise = Exercise::factory()->create([
            'name'             => '::old name::',
            'description'      => '::old description::',
            'break_duration_s' => 10,
        ]);

        $this
            ->patchJson(route('training.exercise.update', $exercise), [
                'name'              => '::new name::',
                'description'       => '::new description::',
                'break_duration_s'  => 1000,
                'muscle_groups_ids' => [MuscleGroup::factory()->create()->id],
            ])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('name', '::new name::')
                ->where('description', '::new description::')
                ->whereAllType($this->exerciseJsonStructure(appends: [
                    'muscle_groups' => 'array',
                ]))
                ->has('muscle_groups', fn(AssertableJson $json) => $json
                    ->count(1)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->muscleGroupJsonStructure(appends: [
                            'pivot' => 'array',
                        ]))
                    )
                )
            );
    }

    /**
     * @dataProvider invalidCreateDataProvider
     */
    public function testValidationForExerciseCreate(array $dataSet): void
    {
        $this
            ->postJson(route('training.exercise.create'), $dataSet)
            ->assertUnprocessable()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('message')
                ->has('errors')
            );
    }

    /**
     * @dataProvider invalidUpdateDataProvider
     */
    public function testValidationForExerciseUpdate(array $dataSet): void
    {
        $this
            ->patchJson(route('training.exercise.update', Exercise::factory()->create()), $dataSet)
            ->assertUnprocessable()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('message')
                ->has('errors')
            );
    }

    public function testDeleteExercise(): void
    {
        $exercise = Exercise::factory()->create();

        $this
            ->deleteJson(route('training.exercise.delete', $exercise))
            ->assertOk();

        $this->assertDatabaseMissing('exercises', $exercise->toArray());
    }

    public function invalidCreateDataProvider(): array
    {
        return [
            'Null value properties'     => [
                [
                    'name'             => null,
                    'description'      => null,
                    'break_duration_s' => null,
                ],
            ],
            'Empty properties'          => [
                [
                    'name'             => '',
                    'description'      => '',
                    'break_duration_s' => 0,
                ],
            ],
            'Exceeded number range'     => [
                [
                    'name'             => '::name::',
                    'description'      => '::description::',
                    'break_duration_s' => 1_000_000,
                ],
            ],
            'Empty data'                => [
                [],
            ],
            'Lacking required property' => [
                [
                    'name'        => '::name::',
                    'description' => '::description::',
                ],
            ],
            'Bad relation primary keys' => [
                [
                    'name'              => '::name::',
                    'description'       => '::description::',
                    'break_duration_s'  => 90,
                    'muscle_groups_ids' => [
                        '::bad primary key::',
                    ],
                ],
            ],
        ];
    }

    public function invalidUpdateDataProvider(): array
    {
        return [
            'Null value properties'     => [
                [
                    'name'             => null,
                    'description'      => null,
                    'break_duration_s' => null,
                ],
            ],
            'Empty properties'          => [
                [
                    'name'             => null,
                    'description'      => null,
                    'break_duration_s' => 0,
                ],
            ],
            'Bad relation primary keys' => [
                [
                    'name'              => '::name::',
                    'description'       => '::description::',
                    'break_duration_s'  => 90,
                    'muscle_groups_ids' => [
                        '::bad primary key::',
                    ],
                ],
            ],
        ];
    }
}
