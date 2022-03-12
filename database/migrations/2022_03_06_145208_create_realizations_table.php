<?php

use App\Enums\RealizationStatusType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realizations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('training_id')
                ->references('id')
                ->on('trainings');
            $table->dateTime('time_started');
            $table->dateTime('time_ended')->nullable();
            $table->unsignedTinyInteger('status')->default(RealizationStatusType::CREATED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('realizations');
    }
};
