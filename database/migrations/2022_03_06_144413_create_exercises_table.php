<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->smallInteger('break_duration_s');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercises');
    }
};
