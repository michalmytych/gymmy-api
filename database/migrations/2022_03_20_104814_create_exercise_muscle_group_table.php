<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('exercise_muscle_group', function (Blueprint $table) {
            $table
                ->foreignUuid('exercise_id')
                ->references('id')
                ->on('exercises')
                ->cascadeOnDelete();
            $table
                ->foreignUuid('muscle_group_id')
                ->references('id')
                ->on('muscle_groups')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercise_muscle_group');
    }
};
