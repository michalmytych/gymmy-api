<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercise_training', function (Blueprint $table) {
            $table
                ->foreignUuid('exercise_id')
                ->references('id')
                ->on('exercises')
                ->cascadeOnUpdate();
            $table
                ->foreignUuid('training_id')
                ->references('id')
                ->on('trainings')
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercise_training');
    }
};
