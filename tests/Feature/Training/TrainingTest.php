<?php

namespace Tests\Feature\Training;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\Authenticate;
use App\Models\Training\Training;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Exercise\MuscleGroup;
use App\Traits\TestCase\HasModelsJsonStructures;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrainingTest extends TestCase
{
    use Authenticate, RefreshDatabase, HasModelsJsonStructures;

    public function testReturnPaginatedListOfTrainings(): void
    {
        Training::factory(3)->create();

        $this
            ->authenticate()
            ->getJson(route('training.all', [
                'paginated' => true,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasPagination()
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(3)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->trainingJsonStructure())
                    )
                )
            );
    }

    public function testDisablePaginationOnListOfTrainings(): void
    {
        Training::factory(3)->create();

        $this
            ->authenticate()
            ->getJson(route('training.all', [
                'paginated' => false,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->count(3)
                ->each(fn(AssertableJson $json) => $json
                    ->whereAllType($this->trainingJsonStructure())
                )
            );
    }

    public function testFindTrainingById(): void
    {
        $training = Training::factory(3)
            ->create()
            ->first();

        $this
            ->authenticate()
            ->getJson(route('training.find', $training))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('id', $training->id)
                ->whereAllType($this->trainingJsonStructure())
            );
    }

    public function testCreateTraining(): void
    {
        $this
            ->authenticate()
            ->postJson(route('training.create'), [
                'name'          => '::name::',
                'description'   => '::description::',
                'exercises_ids' => Exercise::factory(3)->create()->pluck('id'),
            ])
            ->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('name', '::name::')
                ->where('description', '::description::')
                ->whereAllType($this->trainingJsonStructure(appends: [
                    'exercises' => 'array',
                ]))
                ->has('exercises', fn(AssertableJson $json) => $json
                    ->count(3)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->exerciseJsonStructure(appends: [
                            'pivot' => 'array',
                        ]))
                    )
                )
            );
    }

    public function testUpdateTraining(): void
    {
        $training = Training::factory()->create([
            'name'        => '::old name::',
            'description' => '::old description::',
        ]);

        $this
            ->authenticate()
            ->patchJson(route('training.update', $training), [
                'name'          => '::new name::',
                'exercises_ids' => Exercise::factory(3)->create()->pluck('id'),
            ])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('name', '::new name::')
                ->whereAllType($this->trainingJsonStructure(appends: [
                    'exercises' => 'array',
                ]))
                ->has('exercises', fn(AssertableJson $json) => $json
                    ->count(3)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->exerciseJsonStructure(appends: [
                            'pivot' => 'array',
                        ]))
                    )
                )
            );
    }

    /**
     * @dataProvider invalidCreateDataProvider
     */
    public function testValidationForTrainingCreate(array $dataSet): void
    {
        $this
            ->authenticate()
            ->postJson(route('training.create'), $dataSet)
            ->assertUnprocessable()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('message')
                ->has('errors')
            );
    }

    /**
     * @dataProvider invalidUpdateDataProvider
     */
    public function testValidationForTrainingUpdate(array $dataSet): void
    {
        $this
            ->authenticate()
            ->patchJson(route('training.update', Training::factory()->create()), $dataSet)
            ->assertUnprocessable()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('message')
                ->has('errors')
            );
    }

    public function testFilterTrainingsByExerciseMuscleGroups(): void
    {
        $legs  = MuscleGroup::factory()->create();
        $belly = MuscleGroup::factory()->create();
        $back  = MuscleGroup::factory()->create();

        $pushTraining = Training::factory()->create();
        $pullTraining = Training::factory()->create();

        $exerciseA = Exercise::factory()->create();
        $exerciseB = Exercise::factory()->create();

        $exerciseA
            ->muscleGroups()
            ->sync([$legs->id, $belly->id]);

        $exerciseB
            ->muscleGroups()
            ->sync([$back->id, $belly->id]);

        $pushTraining
            ->exercises()
            ->sync([$exerciseA->id]);

        $pullTraining
            ->exercises()
            ->sync([$exerciseB->id]);

        $this
            ->authenticate()
            ->getJson(route('training.all', [
                'paginated' => false,
                'filters'   => [
                    'muscle_groups' => [
                        $legs->id,
                    ],
                ],
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->count(1)
                ->each(fn(AssertableJson $json) => $json
                    ->where('id', $pushTraining->id)
                    ->etc()
                )
            );
    }

    public function testReturnTrainingWithRelations(): void
    {
        $training = Training::factory()->create();

        $training
            ->exercises()
            ->sync(
                Exercise::factory(3)
                    ->create()
                    ->pluck('id')
            );

        $this
            ->authenticate()
            ->getJson(route('training.find', [
                'training'  => $training->id,
                'relations' => [
                    'exercises',
                    'exercises.muscleGroups',
                ],
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('exercises', fn(AssertableJson $json) => $json
                    ->each(fn(AssertableJson $json) => $json
                        ->has('muscle_groups')
                        ->etc()
                    )
                )
                ->etc()
            );
    }

    public function testReturnTrainingWithCount(): void
    {
        $training = Training::factory()->create();

        $training
            ->exercises()
            ->sync(
                Exercise::factory(3)
                    ->create()
                    ->pluck('id')
            );

        $this
            ->authenticate()
            ->getJson(route('training.find', [
                'training'   => $training->id,
                'with_count' => [
                    'exercises',
                ],
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('exercises_count', 3)
                ->etc()
            );
    }

    /**
     * @dataProvider sortersDataProviders
     */
    public function testTrainingsSorters(array $input, array $output): void
    {
        Training::factory()->createMany($input['data']);

        $this
            ->authenticate()
            ->getJson(route('training.all', [
                'paginated' => false,
                'sorters'   => $input['sorter'],
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereAll($output)
            );
    }

    public function testDeleteTraining(): void
    {
        $training = Training::factory()->create();

        $this
            ->authenticate()
            ->deleteJson(route('training.delete', $training))
            ->assertOk();

        $this->assertDatabaseMissing('trainings', $training->toArray());
    }

    public function sortersDataProviders(): array
    {
        return [
            'Asc name query sorter'        => [
                [
                    'sorter' => [
                        'name' => 'asc',
                    ],
                    'data'   => [
                        ['name' => '0-D'],
                        ['name' => '0-R'],
                        ['name' => '0-A'],
                    ],
                ],
                [
                    '0.name' => '0-A',
                    '1.name' => '0-D',
                    '2.name' => '0-R',
                ],
            ],
            'Desc name query sorter'       => [
                [
                    'sorter' => [
                        'name' => 'desc',
                    ],
                    'data'   => [
                        ['name' => '0-D'],
                        ['name' => '0-R'],
                        ['name' => '0-A'],
                    ],
                ],
                [
                    '0.name' => '0-R',
                    '1.name' => '0-D',
                    '2.name' => '0-A',
                ],
            ]
        ];
    }

    public function invalidCreateDataProvider(): array
    {
        return [
            'Null value properties'     => [
                [
                    'name'        => null,
                    'description' => null,
                ],
            ],
            'Empty string properties'   => [
                [
                    'name'        => '',
                    'description' => '',
                ],
            ],
            'Empty data'                => [
                [],
            ],
            'Lacking required property' => [
                [
                    'name' => '::name::',
                ],
            ],
            'Bad relation primary keys' => [
                [
                    'name'          => '::name::',
                    'description'   => '::description::',
                    'exercises_ids' => [
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
                    'name'        => null,
                    'description' => null,
                ],
            ],
            'Empty properties'          => [
                [
                    'name'        => '',
                    'description' => '',
                ],
            ],
            'Bad relation primary keys' => [
                [
                    'name'          => '::name::',
                    'description'   => '::description::',
                    'exercises_ids' => [
                        '::bad primary key::',
                    ],
                ],
            ],
        ];
    }
}
