<?php

namespace Tests\Feature\Training\Realization;

use Tests\TestCase;
use Tests\Traits\Authenticate;
use App\Models\Training\Training;
use App\Enums\RealizationStatusType;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Training\Realization\Realization;
use App\Traits\TestCase\HasModelsJsonStructures;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RealizationTest extends TestCase
{
    use Authenticate, RefreshDatabase, HasModelsJsonStructures;

    public function testReturnPaginatedListOfRealizations(): void
    {
        Realization::factory(3)->create();

        $this
            ->authenticate()
            ->getJson(route('training.realization.all', [
                'paginated' => true,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasPagination()
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(3)
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->realizationJsonStructure())
                    )
                )
            );
    }

    public function testDisablePaginationOnListOfRealizations(): void
    {
        Realization::factory(3)->create();

        $this
            ->authenticate()
            ->getJson(route('training.realization.all', [
                'paginated' => false,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->count(3)
                ->each(fn(AssertableJson $json) => $json
                    ->whereAllType($this->realizationJsonStructure())
                )
            );
    }

    public function testCompleteStartedRealization(): void
    {
        $realization = Realization::factory()->create([
            'status' => RealizationStatusType::RUNNING,
        ]);

        $this
            ->authenticate()
            ->postJson(route('training.realization.complete', $realization))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::COMPLETED)
                ->whereAllType($this->realizationJsonStructure())
            );

        $this->assertEquals(
            RealizationStatusType::COMPLETED,
            $realization->refresh()->status->value
        );
    }

    public function testCancelStartedRealization(): void
    {
        $realization = Realization::factory()->create([
            'status' => RealizationStatusType::RUNNING,
        ]);

        $this
            ->authenticate()
            ->postJson(route('training.realization.cancel', $realization))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::CANCELED)
                ->whereAllType($this->realizationJsonStructure())
            );

        $this->assertEquals(
            RealizationStatusType::CANCELED,
            $realization->refresh()->status->value
        );
    }

    public function testRealizeTraining(): void
    {
        $training = Training::factory()->create();

        $structure = $this->realizationJsonStructure();

        unset($structure['parent_realization_id']);
        unset($structure['time_ended']);

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-training', $training))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::RUNNING)
                ->whereAllType($structure)
            );
    }

    public function testRealizeExercise(): void
    {
        $exercise = Exercise::factory()->create();

        $training = Training::factory()->create();

        $training
            ->exercises()
            ->sync([$exercise->id]);

        $trainingRealization = Realization::factory()->create([
            'realizationable_id'   => $training->id,
            'realizationable_type' => get_class($training),
            'status'               => RealizationStatusType::RUNNING,
        ]);

        $structure = $this->realizationJsonStructure();

        unset($structure['time_ended']);

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-exercise', [
                'exercise'           => $exercise,
                'parent_realization' => $trainingRealization,
            ]))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::RUNNING)
                ->where('parent_realization_id', $trainingRealization->id)
                ->whereAllType($structure)
            );
    }

    public function testCannotRealizeTrainingWhenIsAlreadyRunning(): void
    {
        $training = Training::factory()->create();

        $training
            ->realizations()
            ->save(Realization::factory()->create([
                'status' => RealizationStatusType::RUNNING,
            ]));

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-training', $training))
            ->assertStatus(400)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('message', 'training.realization.already-running')
                ->etc()
            );
    }

    public function testCannotRealizeExerciseWhenIsAlreadyRunning(): void
    {
        $training  = Training::factory()->create();
        $exerciseA = Exercise::factory()->create();
        $exerciseB = Exercise::factory()->create();

        $training
            ->exercises()
            ->saveMany([$exerciseA, $exerciseB]);

        $trainingRealization = $training
            ->realizations()
            ->save(Realization::factory()->create([
                'status' => RealizationStatusType::RUNNING,
            ]));

        $exerciseA
            ->realizations()
            ->save(Realization::factory()->create([
                'status' => RealizationStatusType::RUNNING,
            ]));

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-exercise', [
                'exercise'           => $exerciseB,
                'parent_realization' => $trainingRealization,
            ]))
            ->assertStatus(400)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('message', 'training.realization.already-running')
                ->etc()
            );
    }

    public function testCannotRealizeExerciseWhenParentIsNotRunning(): void
    {
        $training = Training::factory()->create();
        $exercise = Exercise::factory()->create();

        $training
            ->exercises()
            ->save($exercise);

        $trainingRealization = $training
            ->realizations()
            ->save(Realization::factory()->create([
                'status' => RealizationStatusType::COMPLETED,
            ]));

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-exercise', [
                'exercise'           => $exercise,
                'parent_realization' => $trainingRealization,
            ]))
            ->assertStatus(400)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('message', 'training.realization.parent-realization-not-running')
                ->etc()
            );
    }

    public function testCannotCompleteRealizationWhenAlreadyCompleted(): void
    {
        $training = Training::factory()->create();

        $realization = $training
            ->realizations()
            ->save(Realization::factory()->create([
                'status' => RealizationStatusType::COMPLETED,
            ]));

        $this
            ->authenticate()
            ->postJson(route('training.realization.complete', $realization))
            ->assertStatus(400)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('message', 'realization.is-not-running')
                ->etc()
            );
    }

    public function testCannotCancelRealizationWhenAlreadyCanceled(): void
    {
        $training = Training::factory()->create();

        $realization = $training
            ->realizations()
            ->save(Realization::factory()->create([
                'status' => RealizationStatusType::CANCELED,
            ]));

        $this
            ->authenticate()
            ->postJson(route('training.realization.cancel', $realization))
            ->assertStatus(400)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('message', 'realization.is-not-running')
                ->etc()
            );
    }

    public function testCompleteChildrenRealizationsOfTrainingRealization(): void
    {
        $training = Training::factory()->create();
        $exercise = Exercise::factory()->create();

        $training
            ->exercises()
            ->save($exercise);

        $trainingRealization = $training
            ->realizations()
            ->save(Realization::factory()->create([
                'status' => RealizationStatusType::RUNNING,
            ]));

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-exercise', [
                'exercise'           => $exercise,
                'parent_realization' => $trainingRealization,
            ]))
            ->assertOk();

        $exerciseRealization = $trainingRealization
            ->refresh()
            ->childrenRealizations()
            ->first();

        $this
            ->authenticate()
            ->postJson(route('training.realization.complete', $trainingRealization))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::COMPLETED)
                ->whereAllType($this->realizationJsonStructure())
            );

        $trainingRealizationStatus = $trainingRealization->refresh()->status->value;
        $exerciseRealizationStatus = $exerciseRealization->refresh()->status->value;

        $this->assertEquals(
            RealizationStatusType::COMPLETED,
            $trainingRealizationStatus,
            'Expected status ' . RealizationStatusType::getDescription(RealizationStatusType::COMPLETED)
            . ' got ' . RealizationStatusType::getDescription($trainingRealization->refresh()->status->value)
        );

        $this->assertEquals(
            RealizationStatusType::COMPLETED,
            $exerciseRealizationStatus,
            'Expected status ' . RealizationStatusType::getDescription(RealizationStatusType::COMPLETED)
            . ' got ' . RealizationStatusType::getDescription($exerciseRealization->refresh()->status->value)
        );
    }

    public function testCancelChildrenRealizationsOfTrainingRealization(): void
    {
        $training = Training::factory()->create();
        $exercise = Exercise::factory()->create();

        $training
            ->exercises()
            ->save($exercise);

        $trainingRealization = $training
            ->realizations()
            ->save(Realization::factory()->create([
                'status' => RealizationStatusType::RUNNING,
            ]));

        $this
            ->authenticate()
            ->postJson(route('training.realization.realize-exercise', [
                'exercise'           => $exercise,
                'parent_realization' => $trainingRealization,
            ]))
            ->assertOk();

        $exerciseRealization = $exercise
            ->refresh()
            ->realizations()
            ->first();

        $this
            ->authenticate()
            ->postJson(route('training.realization.cancel', $trainingRealization))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('status', RealizationStatusType::CANCELED)
                ->whereAllType($this->realizationJsonStructure())
            );

        $trainingRealizationStatus = $trainingRealization->refresh()->status->value;
        $exerciseRealizationStatus = $exerciseRealization->refresh()->status->value;

        $this->assertEquals(
            RealizationStatusType::CANCELED,
            $trainingRealizationStatus,
            'Expected status ' . RealizationStatusType::getDescription(RealizationStatusType::COMPLETED)
            . ' got ' . RealizationStatusType::getDescription($trainingRealization->refresh()->status->value)
        );

        $this->assertEquals(
            RealizationStatusType::CANCELED,
            $exerciseRealizationStatus,
            'Expected status ' . RealizationStatusType::getDescription(RealizationStatusType::COMPLETED)
            . ' got ' . RealizationStatusType::getDescription($exerciseRealization->refresh()->status->value)
        );
    }
}
