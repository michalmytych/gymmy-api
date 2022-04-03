<?php

use App\Enums\RealizationStatusType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->dateTime('time_started');
            $table->dateTime('time_ended')->nullable();
            $table->uuidMorphs('realizationable');
            $table
                ->unsignedTinyInteger('status')
                ->default(RealizationStatusType::CREATED);
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
