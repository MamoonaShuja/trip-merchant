<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Tour\Enum\CityTypes;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_city', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id');
            $table->foreignId('tour_id');
            $table->enum('type' , [
                CityTypes::ARRIVAL_CITY->value,
                CityTypes::DEPARTURE_CITY->value,
            ]);
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('tour_city');
    }
};
