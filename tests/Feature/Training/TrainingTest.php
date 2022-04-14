<?php

namespace Tests\Feature\Training;

use Tests\TestCase;
use Tests\Traits\Authenticate;
use App\Models\Training\Training;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Testing\Fluent\AssertableJson;
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

    public function testDeleteTraining(): void
    {
        $training = Training::factory()->create();

        $this
            ->authenticate()
            ->deleteJson(route('training.delete', $training))
            ->assertOk();

        $this->assertDatabaseMissing('trainings', $training->toArray());
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
